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
        $order = auth()->user()->orders()->create([
            'total_price' => $request->total_price
        ]);

        return response()->json($order, 201);
    }

    public function show($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json($order, 200);
    }
}
