<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);

        $payment = Payment::create([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Payment initiated', 'payment' => $payment]);
    }

    public function confirmPayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'paid']);

        return response()->json(['message' => 'Payment confirmed']);
    }
}
