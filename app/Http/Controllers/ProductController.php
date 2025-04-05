<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        // Middleware pour s'assurer que l'utilisateur est authentifié pour certaines actions
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
        
        // Middleware admin uniquement pour les actions de gestion des produits
        $this->middleware('admin')->only(['store', 'update', 'destroy']);
    }

    public function index()
    {
        return response()->json(Product::all(), 200);  // Pas besoin d'authentification
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product, 200);  // Pas besoin d'authentification
    }

    // Les autres méthodes (store, update, destroy) nécessitent authentification et rôle admin
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
        ]);

        try {
            $product = Product::create($request->all());
            return response()->json([
                'message' => 'Produit ajouté avec succès',
                'product' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de l\'ajout du produit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'image' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
            'stock' => 'sometimes|integer|min:0',
        ]);

        $product->update($request->all());

        return response()->json([
            'message' => 'Produit mis à jour avec succès',
            'product' => $product
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted'], 200);
    }


    public function search(Request $request)
    {
        $query = Product::with('category'); // Chargement relation category
        
        // Recherche par nom
        if ($request->has('q')) {
            $searchTerm = $request->q;
            $query->where('name', 'like', '%'.$searchTerm.'%')
                  ->orWhere('description', 'like', '%'.$searchTerm.'%');
        }
        
        // Filtre par catégorie
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        // Tri
        $sortField = $request->has('sort_by') ? $request->sort_by : 'created_at';
        $sortDirection = $request->has('sort_dir') ? $request->sort_dir : 'desc';
        $query->orderBy($sortField, $sortDirection);
        
        // Pagination
        $perPage = $request->has('per_page') ? $request->per_page : 15;
        $products = $query->paginate($perPage);
        
        return response()->json([
            'data' => $products->items(),
            'meta' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]
        ]);
    }
    
    public function getCategories()
    {
        $categories = Category::select('id', 'name')->get();
        return response()->json($categories);
    }
}