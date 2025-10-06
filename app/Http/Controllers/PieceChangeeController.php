<?php

namespace App\Http\Controllers;

use App\Models\PieceChangee;
use Illuminate\Http\Request;

class PieceChangeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'intervention_id' => 'required|exists:interventions,id',
            'nom_piece' => 'required|string|max:255',
            'quantite' => 'required|integer|min:1',
            'prix_unitaire' => 'required|numeric|min:0',
        ]);

        PieceChangee::create([
            'intervention_id' => $request->intervention_id,
            'nom_piece' => $request->nom_piece,
            'quantite' => $request->quantite,
            'prix_unitaire' => $request->prix_unitaire,
        ]);

        return redirect()->back()->with('success', 'Pièce ajoutée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(PieceChangee $pieceChangee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PieceChangee $pieceChangee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PieceChangee $pieceChangee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PieceChangee $piece)
    {
        $piece->delete();
        
        return redirect()->back()->with('success', 'Pièce supprimée avec succès');
    }
}
