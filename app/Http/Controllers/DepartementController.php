<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departements = Departement::all();
        return view('admin.pages.departement.index', compact('departements'));
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
            'description' => 'required|string',
        ]);

        $departement = Departement::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return redirect()->route('departements.index')
            ->with('success', 'Le département a été créé avec succès.');
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
        $departement = Departement::findOrFail($id);

        $request->validate([
            'nom' => 'string|max:255',
            'description' => 'string',
        ]);

        $departement->update([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return redirect()->route('departements.index')
            ->with('success', 'Le département a été créé avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $departement = Departement::find($id);
        $departement->delete();

        return redirect()->route('departements.index')->with('success', 'Département supprimé avec succès !');
    }
}
