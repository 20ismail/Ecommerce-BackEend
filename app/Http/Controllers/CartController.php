<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Cart;


class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::create($request->all());

        return response()->json(['message' => 'Product added to cart', 'cart' => $cart]);
    }

    public function removeProduct($id)
    {
        Cart::destroy($id);
        return response()->json(['message' => 'Product removed from cart']);
    }

    public function viewCart($userId)
    {
        return Cart::where('user_id', $userId)->with('product')->get();
    }
}
