<?php

namespace App\Http\Controllers;

use App\Models\StatutAbsence;
use Illuminate\Http\Request;

class StatutAbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuts = StatutAbsence::all();
        $notifications = auth()->user()->unreadNotifications;
        return view('admin.pages.absence.statut', compact('statuts','notifications'));
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
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        StatutAbsence::create($request->only(['nom', 'description']));

        return redirect()->route('statuts.index')
            ->with('success', 'Motif Absence créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $motif = StatutAbsence::find($id);

        if (!$motif) {
            return redirect()->route('statuts.index')
                ->with('error', 'motif not found.');
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $motif->update([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return redirect()->route('statuts.index')
            ->with('success', 'Le Motif d\'Absence a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $motif = StatutAbsence::find($id);
        $motif->delete();

        return redirect()->route('statuts.index')->with('success', 'Motif d\'Absence supprimé avec succès !');
    }
}
