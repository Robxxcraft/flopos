<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllCategoryResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\HomeCategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function all()
    {
        $categories = Category::all();
        return AllCategoryResource::collection($categories);
    }

    public function index(Request $request)
    {
        $categories = Category::when($request->has('search'), function($q)use($request){
            $q->where('name', 'like', '%'.$request->search.'%')->orWhere('id', (int)$request->search);
        })->latest()->simplePaginate(10);
        return CategoryResource::collection($categories);
        
    }

    public function home()
    {
        $categories = Category::all();
        return HomeCategoryResource::collection($categories);
    }

    public function create(Request $request)
    {

        $request->validate([
            'name' => 'required|min:3|unique:categories,name'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
            
        return response()->json('Category added successfully', 201);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|unique:categories,name,'.$id
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return response()->json('Category updated successfully', 201);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json('Category deleted sucessfullfy', 200);
    }

    public function deleteAll()
    {
        DB::table('categories')->delete();

        return response()->json('All Categories deleted', 200);
    }
    
}
