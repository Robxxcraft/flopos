<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')->when($request->has('search'), function($q)use($request){
            $q->where('title', 'like', '%'.$request->search.'%')->orWhere('description', 'like', '%'.$request->search.'%')->orWhere('price', 'like', '%'.$request->search.'%')->orWhere('price', 'like', '%'.$request->search.'%')->orWhere('stock', 'like', '%'.$request->search.'%')->orWhere('id', (int)$request->search);
        })->latest()->paginate(10);
        return ProductResource::collection($products);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json('User deleted sucessfullfy', 200);
    }
}
