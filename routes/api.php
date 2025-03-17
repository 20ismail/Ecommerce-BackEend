<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Routes pour l'utilisateur (middleware auth:sanctum pour s'assurer que l'utilisateur est connecté)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user/profile', function (Request $request) {
        return response()->json($request->user());
    });

    // Produits (accès lecture seulement pour les utilisateurs)
    Route::get('/products', [ProductController::class, 'index']);  // Liste des produits
    Route::get('/products/{id}', [ProductController::class, 'show']); // Détails d'un produit

    // Gestion du panier
    Route::get('/cart', [CartController::class, 'index']); // Voir son panier
    Route::post('/cart/add', [CartController::class, 'store']); // Ajouter au panier
    Route::put('/cart/update/{id}', [CartController::class, 'update']); // Modifier un article
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy']); // Supprimer du panier

    // Commandes
    Route::post('/orders', [OrderController::class, 'store']); // Passer une commande
    Route::get('/orders', [OrderController::class, 'index']); // Voir ses commandes
    Route::get('/orders/{id}', [OrderController::class, 'show']); // Détails d'une commande
});

// Routes Admin (CRUD produits, voir toutes les commandes)
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    // Gestion des produits (CRUD)
    Route::post('/products', [ProductController::class, 'store']); // Ajouter un produit
    Route::put('/products/{id}', [ProductController::class, 'update']); // Modifier un produit
    Route::delete('/products/{id}', [ProductController::class, 'destroy']); // Supprimer un produit

    // Gestion des commandes
    Route::get('/orders', [OrderController::class, 'adminIndex']); // Voir toutes les commandes
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']); // Modifier le statut d'une commande
});