<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
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
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
            'subject' => 'required|string|max:255', // Ajout de la validation pour le subject
        ]);

        Contact::create($request->all());

        return response()->json(['message' => 'Message envoyé avec succès !'], 201);
    }

    // Lister les messages (ex: pour admin)
    public function index()
    {
        return response()->json(Contact::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contacter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contacter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contacter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contacter)
    {
        $contacter->delete();

        return response()->json(['message' => 'Message supprimé avec succès.'], 200);
    }

}
