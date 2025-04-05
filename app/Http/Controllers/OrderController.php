<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
/* The line `use App\Models\Product;` in the PHP code snippet is importing the `Product` model class
from the `App\Models` namespace. This allows the `OrderController` to use the `Product` model within
its methods without having to specify the full namespace every time. By importing the `Product`
model, the controller can interact with the `Product` database table and perform operations such as
finding products, checking stock availability, and updating product information. */
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;
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
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        if (!isset($request->products) || count($request->products) === 0) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }
    
        
        DB::beginTransaction();
    
        try {
            
            foreach ($request->products as $product) {
                $productModel = Product::find($product['id']);
    
                if (!$productModel || $productModel->stock < $product['quantity']) {
                    return response()->json([
                        'error' => 'Stock insuffisant pour le produit : ' . ($productModel ? $productModel->name : 'Produit inconnu') . 
                                   '. Stock restant : ' . ($productModel ? $productModel->stock : '0')
                    ], 400);
                }
            }
    
           
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $request->total_amount,
                'status' => 'pending',
            ]);
    
           
            foreach ($request->products as $product) {
                
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                ]);
    
                
                $productModel = Product::find($product['id']);
                $productModel->stock -= $product['quantity'];
                $productModel->save();
            }
    
          
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $request->total_amount,
                'payment_method' => $request->payment_method ?? 'credit_card', 
                'status' => 'pending',
                'payment_date' => now(), 
            ]);
    
            
            DB::commit();
    
            return response()->json(['message' => 'Order placed successfully', 'order_id' => $order->id, 'payment_id' => $payment->id], 201);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Order processing failed', 'details' => $e->getMessage()], 500);
        }
    }
    
    
    

    public function show($id)
    {
        $order = Order::with('products')->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json($order, 200);
    }

    public function adminIndex(Request $request)
    {
        $query = Order::with(['user', 'products']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->select('id', 'user_id', 'total_amount', 'status', 'created_at')->get();

        return response()->json($orders, 200);
    }

    public function updateStatus(Request $request, $id)
    {
        // Vérification si la commande existe
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Commande non trouvée'], 404);
        }

        // Validation du statut dans la requête (ex: pending, validated, shipped, etc.)
        $request->validate([
            'status' => 'required|string|in:pending,validated,completed,cancelled',
        ]);

        // Mise à jour du statut de la commande
        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Statut de la commande mis à jour avec succès',
            'order' => $order
        ], 200);
    }


}
