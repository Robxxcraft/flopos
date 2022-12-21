<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::when($request->has('search'), function($q)use($request){
            $q->where('name', 'like', '%'.$request->search.'%')->orWhere('age', 'like', '%'.$request->search.'%')->orWhere('email', 'like', '%'.$request->search.'%')->orWhere('phone', 'like', '%'.$request->search.'%')->orWhere('address', 'like', '%'.$request->search.'%')->orWhere('zipcode', 'like', '%'.$request->search.'%')->orWhere('id', (int)$request->search);
        })->latest()->simplePaginate(10);
        return CustomerResource::collection($customers);
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:customers,name',
            'age' => 'required|numeric|max:150',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits_between:1,15',
            'address' => 'required|min:5',
            'zipcode' => 'required'
        ]);

        Customer::create([
            'name' => $request->name,
            'age' => $request->age,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'zipcode' => $request->zipcode,
        ]);
        return response()->json("Customer created successfully", 200);
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|unique:customers,name,'.$id,
            'age' => 'required|numeric|max:3',
            'email' => 'required|email',
            'phone' => 'required|numeric|max:15',
            'address' => 'required|min:5',
            'zipcode' => 'required',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update([
            'name' => $request->name,
            'age' => $request->age,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'zipcode' => $request->zipcode
        ]);
        return response()->json("Customer updated successfully", 200);
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json("Customer deleted successfully", 200);
    }
}