<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric'
        ]);

        $payment = Payment::create([
            'order_id' => $request->order_id,
            'amount' => $request->amount
        ]);

        return response()->json($payment, 201);
    }

    public function index()
    {
        return response()->json(auth()->user()->payments, 200);
    }
}
