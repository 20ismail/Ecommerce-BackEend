<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/contact', [ContactController::class, 'store']);
// Pour voir les messages (admin)
Route::get('/catalog', [ProductController::class, 'search']); // Recherche avec filtres
Route::get('/catalog/categories', [ProductController::class, 'getCategories']); // Liste des cat
// routes/api.php
Route::get('/items', function() {
    return response()->json([
        'data' => \App\Models\Product::select([
            'id',
            'name', 
            'description',
            'price',
            'image'
        ])->get()
    ]);
});


Route::get('/shop/products', [ProductController::class, 'index']);  // Pas d'authentification nécessaire
Route::get('/shop/products/{id}', [ProductController::class, 'show']);  // Pas d'authentification nécessaire

// Route::post('/contact', [ContactController::class, 'store']);
// Route::get('/contacts', [ContactController::class, 'index']); // Pour voir les messages (admin)


Route::get('/shop/products', [ProductController::class, 'index']);  // Pas d'authentification nécessaire
Route::get('/shop/products/{id}', [ProductController::class, 'show']);  // Pas d'authentification nécessaire

// Route pour categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


// Routes pour l'utilisateur (auth:sanctum pour s'assurer que l'utilisateur est connecté)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user/profile', function (Request $request) {
        return response()->json($request->user());
    });

        // Récupérer les infos de l'utilisateur connecté
        Route::get('/profile', [ProfileController::class, 'show']);
        // Mettre à jour le profil
        Route::put('/profile', [ProfileController::class, 'update']);
        // Mettre à jour le mot de passe
        Route::put('/profile/password', [ProfileController::class, 'updatePassword']);
        
    // Produits (lecture seulement)
    Route::get('/products', [ProductController::class, 'index']);  
    Route::get('/products/{id}', [ProductController::class, 'show']); 

    // Gestion du panier
    Route::get('/cart', [CartController::class, 'index']); 
    Route::post('/cart/add', [CartController::class, 'store']); 
    Route::put('/cart/update/{id}', [CartController::class, 'update']); 
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy']); 

    // Commandes
    Route::post('/orders', [OrderController::class, 'store']); 
    Route::get('/orders', [OrderController::class, 'index']); 
    Route::get('/orders/{id}', [OrderController::class, 'show']); 
    // Produits (lecture seulement)-----------
    Route::get('/products', [ProductController::class, 'index']);  
    Route::get('/products/{id}', [ProductController::class, 'show']);
});

// Routes Admin (CRUD Produits & Catégories, gestion commandes)
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    // Gestion des produits (CRUD)
    Route::post('/products', [ProductController::class, 'store']); 
    Route::put('/products/{id}', [ProductController::class, 'update']); 
    Route::delete('/products/{id}', [ProductController::class, 'destroy']); 

    // Gestion des catégories (CRUD)
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // Gestion des commandes
    Route::get('/orders', [OrderController::class, 'adminIndex']); 
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']); 

    // Recuperer tous les utilisateurs
    Route::get('/users', [AuthController::class, 'getAllUsers']); 
    Route::delete('/users/{id}', [AuthController::class, 'deleteUser']);
    Route::get('/users/{id}', [AuthController::class, 'getUserById']);

    // messages
    Route::get('/contact', [ContactController::class, 'index']); 
    Route::delete('/contact/{contacter}', [ContactController::class, 'destroy']);

    
     // Récupérer le profil utilisateur
    //  Route::get('/user/profile', [AuthController::class, 'getProfile']);
    
    //  // Mettre à jour le profil
    //  Route::put('/user/profile', [AuthController::class, 'updateProfile']);

  
});
