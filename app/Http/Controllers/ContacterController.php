<?php

namespace App\Http\Controllers;

use App\Models\Contacter;
use Illuminate\Http\Request;

class ContacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */// Enregistrer un message
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        Contacter::create($request->all());

        return response()->json(['message' => 'Message envoyé avec succès !'], 201);
    }

    // Lister les messages (ex: pour admin)
    public function index()
    {
        return response()->json(Contacter::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Contacter $contacter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contacter $contacter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contacter $contacter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contacter $contacter)
    {
        //
    }
}
