<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function index(){
        $cart = Auth::user()->cart();
        $totalQuantity = Auth::user('sanctum')->cartTotalQuantity();
        return CartResource::collection($cart)->additional(['meta' => [
            'total_quantity' => (int) $totalQuantity
        ]]);
    }

    public function store(Request $request){
        $item = Cart::where('user_id', Auth::user()->id)->where('product_id', $request->product_id);

        if ($item->count()) {
            $item->increment('quantity', $request->quantity);
        } else {
            if (Cart::where('user_id', Auth::user()->id)->count() >= 100) {
                throw ValidationException::withMessages(['error'=>'Cart must be not greater than 100']);
            }
            $item = Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return;
    }

    public function destroy($productId){
    	$item = Cart::where('user_id', Auth::user()->id)->find($productId);
        $item->delete();
        return;
    }

    public function updateQty(Request $request, $id){
    	$item = Cart::where('user_id', Auth::user()->id)->find($id);
        $item->quantity = $request->quantity;
        $item->update();
        return;
    }

    public function incrementQty($id){
    	$item = Cart::where('user_id', Auth::user()->id)->where('product_id', $id)->first();
        $item->quantity++;
        $item->update();
        return;
    }

    public function decrementQty($id){
    	$item = Cart::where('user_id', Auth::user()->id)->where('product_id', $id)->first();
        if ($item->quantity <= 1) {
            return;
        }
        $item->quantity--;
        $item->update();
        return;
    }

    public function cartClear(){
        $carts = Auth::user()->cart;
        foreach ($carts as $cart) {
            $cart = Cart::find($cart->id);
            $cart->delete();
        }
        return response()->json('Cart Cleared', 200);
    }
}
