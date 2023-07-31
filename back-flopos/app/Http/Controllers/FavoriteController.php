<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductHomeResource;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index(Request $request){
        $products = Product::whereHas('favorite', function($q){ $q->where('user_id', Auth::user()->id); })->with('category')->withCount('favorited')->when($request->has('search'), function($q)use($request){
            $q->where('title', 'like', '%'.$request->search.'%')->orWhere('price', 'like', '%'.$request->search.'%')->orWhere('stock', 'like', '%'.$request->search.'%');
        })->when($request->has('sortColumn') && $request->has('sortType'), function($q)use($request){
            $q->orderBy($request->sortColumn, $request->sortType);
        })->latest()->simplePaginate(12);
        return ProductHomeResource::collection($products);
    }

    public function add($id){
        Favorite::firstOrCreate([
            'user_id' => Auth::user()->id,
            'product_id' => $id,
        ]);

        return response()->json('Product favorited', 201);
    }

    public function remove($id){
        $favorite = Favorite::where('user_id',Auth::user()->id)->where('product_id',$id);
        $favorite->delete();

        return response()->json('Product unfavorited', 200);
    }
}
