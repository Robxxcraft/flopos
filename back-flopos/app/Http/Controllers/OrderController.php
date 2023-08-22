<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminOrderResource;
use App\Http\Resources\userOrderResource;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::where('user_id', Auth::user()->id)->with('orderdetails.product')->get();
        
        return response()->json($orders, 200);
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::user()->id)->with('orderdetails.product', function($q){
            $q->with('category');
        })->find($id);
        
        return response()->json($order, 200);
    }

    public function adminShowOrder($id)
    {
        $order = Order::with(['orderdetails.product.category', 'user'])->find($id);
        
        return response()->json($order, 200);
    }

    public function admin(Request $request){
        $orders = Order::with('user')->when($request->has('search'), function($q)use($request){
            $q->where('token', 'like', '%'.$request->search.'%')->orWhere('total_amount', 'like', '%'.$request->search.'%')->orWhere('total_amount', 'like', '%'.$request->search.'%')->orWhere('courier', 'like', '%'.$request->search.'%')->orWhere('payment', 'like', '%'.$request->search.'%')->orWhere('address', 'like', '%'.$request->search.'%')->orWhere('zipcode', 'like', '%'.$request->search.'%')->orWhere('id', (int)$request->search);
        })->latest()->simplePaginate(10);
        return AdminOrderResource::collection($orders);
    }

    public function userOrders(){
        $orders = Order::where('user_id', Auth::user()->id)->with('user')->latest()->paginate(10);
        
        return userOrderResource::collection($orders);
    }

    public function userOrderDetails($id){
        $order = Order::where('id', $id)->with(['user','orderdetails.product'])->first();
        
        return response()->json($order, 200);
    }

    public function create(Request $request){
        $request->validate([
            'phone' => 'required|numeric',
            'address' => 'required|min:5|max:500',
            'zipcode' => 'required|numeric',
            'courier' => 'required',
            'total_amount' => 'min:1',
            'payment' => 'required'
        ]);
        

        $carts = Auth::user('sanctum')->cartAll;
        if ($carts->count() < 1) {
            throw ValidationException::withMessages(['product' => 'Min 1 quantity of product to create an order']);
        }

        $total_amount = 0;
        $total_quantity = 0;
        foreach ($carts as $cart) {
            $total_quantity += $cart->quantity;
            $total_amount += $cart->product->price*$cart->quantity;
        }

        switch ($request->courier) {
            case 'GoSend':
                $total_amount += 7;
                break;
            case 'JnE':
                $total_amount += 5;
                break;
            case 'JnT':
                $total_amount += 6;
                break;
            case 'Sicepat':
                $total_amount += 8;
                break;
            
            default:
                break;
        }

        $order = Order::create([
            'token' => Str::random(20),
            'user_id' => Auth::user('sanctum')->id,
            'phone' => $request->phone,
            'address' => $request->address,
            'zipcode' => $request->zipcode,
            'total_quantity' => $total_quantity,
            'total_amount' => $total_amount,
            'courier' => $request->courier,
            'payment' => $request->payment
        ]);

        if (isset($order)) {
            foreach ($carts as $cart) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                ]);
                $product = Product::find($cart->product_id);
                $product->update([
                    'stock' => (int)$product->stock - (int) $cart->quantity
                ]);
            }

            foreach ($carts as $cart) {
                $cart = Cart::find($cart->id);
                $cart->delete();
            }

            return response()->json('Order created successfully', 201);
        }

        return response()->json('Some error occured', 500);

    }

    public function destroy($id){
        $order = Order::find($id);
        $order->delete();

        return response()->json('Order Deleted Successfully', 201);
    }
}