<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return response()->json(auth()->user()->cart, 200);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $cart = auth()->user()->cart()->create($request->all());

            return response()->json($cart, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Recherche de l'élément du panier avec l'ID donné
        $cartItem = Cart::find($id);

        // Vérifie si l'élément du panier existe
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        // Vérifie si l'élément du panier appartient à l'utilisateur authentifié
        if ($cartItem->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Mise à jour de la quantité
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        // Retour de la réponse avec l'élément mis à jour
        return response()->json($cartItem, 200);
    }

    public function destroy($id)
    {
        $cartItem = Cart::find($id);
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart'], 200);
    }
}
