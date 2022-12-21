<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder;

class SalesOrderController extends Controller
{
    public function index()
    {
        $orders = SalesOrder::all();
        return response()->json($orders, 200);
    }
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|unique:sales_orders,title',
            'price' => 'required|numeric'
        ]);

        SalesOrder::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price
        ]);
        return response()->json("SalesOrder created successfully", 200);
    }
    public function show()
    {
        $orders = SalesOrder::all();
        return response()->json($orders, 200);
    }

    public function edit($id)
    {
        $product = SalesOrder::findOrFail($id);
        return response()->json($product, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:3|unique:sales_orders,title,'.$id,
            'price' => 'required|numeric'
        ]);

        $product = SalesOrder::findOrFail($id);
        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price
        ]);
        return response()->json("SalesOrder created successfully", 200);
    }

    public function destroy($id)
    {
        $product = SalesOrder::findOrFail($id);
        $product->delete();
        return response()->json("SalesOrder deleted successfully", 200);
    }
}