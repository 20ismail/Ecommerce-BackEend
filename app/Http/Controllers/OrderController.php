<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return response()->json(auth()->user()->orders, 200);
    }   


        public function store(Request $request)
    {
        $request->validate([
            'total_amount' => 'required|numeric',
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        $order = auth()->user()->orders()->create([
            'total_amount' => $request->total_amount
        ]);

        foreach ($request->products as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return response()->json($order->load('products'), 201);
    }

    public function show($id)
{
    $order = Order::with('products')->find($id);
    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }
    return response()->json($order, 200);
}
}
