<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoritedResource;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index(){
        $products = Product::whereHas('favorite', function($q){ $q->where('user_id', Auth::user()->id); })->with('category')->latest()->simplePaginate(12);
        return FavoritedResource::collection($products);
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
