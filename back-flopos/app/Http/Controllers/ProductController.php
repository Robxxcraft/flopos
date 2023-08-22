<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminProductShowResource;
use App\Http\Resources\ProductDetailsResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductHomeResource;
use App\Models\Product;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller{

    public function __construct(){
        if (Auth::guard('sanctum')->check()) {
            $this->middleware('auth:sanctum')->only('details');
        }    
    }

    public function admin(Request $request){
        $products = Product::with('category')->when($request->has('search'), function($q)use($request){
            $q->where('title', 'like', '%'.$request->search.'%')->orWhere('description', 'like', '%'.$request->search.'%')->orWhere('price', 'like', '%'.$request->search.'%')->orWhere('price', 'like', '%'.$request->search.'%')->orWhere('stock', 'like', '%'.$request->search.'%')->orWhere('id', (int)$request->search);
        })->latest()->paginate(10);
        return ProductResource::collection($products);
    }

    public function home(Request $request){
        $products = Product::with('category')->withCount('favorited')->when($request->has('category'), function($q)use($request){
            $q->whereHas('category', function($q)use($request){ $q->where('slug', $request->category); });
        })->when($request->has('search'), function($q)use($request){
            $q->where('title', 'like', '%'.$request->search.'%')->orWhere('price', 'like', '%'.$request->search.'%')->orWhere('stock', 'like', '%'.$request->search.'%');
        })->when($request->has('sortColumn') && $request->has('sortType'), function($q)use($request){
            $q->orderBy($request->sortColumn, $request->sortType);
        })->latest()->simplePaginate(12);
        return ProductHomeResource::collection($products);
    }
    public function create(Request $request){
        $request->validate([
            'title' => 'required|min:3|unique:products,title',
            'category' => 'required',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1|max:2500',
        ]);

        $product = Product::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'category_id' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock
        ]);

        //deploy
        if ($request->hasFile('photo')) {
            $uploadImg = Cloudinary::upload($request->file('photo')->getRealPath(), [
                'folder' =>  'pos',
                'public_id' => 'pos_product_'.$product->created_at->format('Y-m-d').'_'.$product->id,
                'transformation' => [
                    'width' => 600,
                    'heigth' => 400,
                ]
            ]);
            $product->photo = $uploadImg->getSecurePath();
            $product->save();
        }

        return response()->json("Product created successfully", 200);
    }

    public function show($id){
        $product = Product::with('category')->findOrFail($id);
        return new AdminProductShowResource($product);
    }

    public function details($slug){
        $product = Product::with('category')->withCount('favorited')->where('slug', $slug)->first();
        return new ProductDetailsResource($product);
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required|min:3|unique:products,title,'.$id,
            'price' => 'required|numeric'
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'category_id' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock
        ]);
        // deploy
        if ($request->hasFile('photo')) {
            if (strpos($product->photo, 'cloudinary') !== false) {
                Cloudinary::destroy('pos_product_'.$product->created_at->format('Y-m-d').'_'.$product->id);
            }
            $uploadImg = Cloudinary::upload($request->file('photo')->getRealPath(), [
                'folder' =>  'pos',
                'public_id' => 'pos_product_'.$product->created_at->format('Y-m-d').'_'.$product->id,
                'transformation' => [
                    'width' => 600,
                    'heigth' => 400,
                ]
            ]);
            $product->photo = $uploadImg->getSecurePath();
            $product->save();
        }
        return response()->json("Product updated successfully", 200);
    }

    public function destroy($id){
        $product = Product::findOrFail($id);
        //deploy
        if (isset($product->photo) && strpos($product->photo, 'cloudinary') !== false) {
            Cloudinary::destroy('pos_product_'.$product->created_at->format('Y-m-d').'_'.$product->id);
        }
        $product->delete();
        return response()->json("Product deleted successfully", 200);
    }
}
