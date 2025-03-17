<?php

namespace App\Http\Controllers;
use App\Models\Order;


use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric',
        ]);

        $order = Order::create([
            'user_id' => $request->user_id,
            'total_amount' => $request->total_amount,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Order created successfully', 'order' => $order]);
    }

    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'completed']);

        return response()->json(['message' => 'Order completed']);
    }
}
