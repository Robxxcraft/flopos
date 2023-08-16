<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::when($request->has('search'), function($q)use($request){
            $q->where('name', 'like', '%'.$request->search.'%')->orWhere('id', (int)$request->search);
        })->latest()->simplePaginate(10);
        return CategoryResource::collection($categories);
        
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json('User deleted sucessfullfy', 200);
    }
}
