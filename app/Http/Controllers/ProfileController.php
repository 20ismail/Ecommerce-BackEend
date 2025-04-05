<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
   
     // Récupérer les infos de l'utilisateur
     public function show()
     {
         return response()->json(Auth::user());
     }
 
     // Mettre à jour le profil
     public function update(Request $request)
     {
         $user = Auth::user();
 
         $validated = $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
         ]);
 
         $user->update($validated);
 
         return response()->json($user);
     }
 
     // Mettre à jour le mot de passe
     public function updatePassword(Request $request)
     {
         $request->validate([
             'current_password' => 'required|string',
             'password' => ['required', 'confirmed', Password::defaults()],
         ]);
 
         $user = Auth::user();
 
         if (!Hash::check($request->current_password, $user->password)) {
             return response()->json(['message' => 'Le mot de passe actuel est incorrect'], 422);
         }
 
         $user->update([
             'password' => Hash::make($request->password),
         ]);
 
         return response()->json(['message' => 'Mot de passe mis à jour avec succès']);
     }
}
