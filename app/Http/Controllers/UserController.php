<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $departements = Departement::all();
        $users = User::all();
        return view('admin.pages.utilisateur.index', compact('departements', 'roles', 'users'));
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
            'departement_id' => 'required|integer',
            'role_id' => 'required|integer',
            'nom' => 'required|string',
            'prenoms' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'contact' => 'nullable|string',
            'adresse' => 'nullable|string',
            'genre' => 'nullable|string|in:Masculin,Feminin',
        ]);

        $user = new User();
        $user->departement_id = $request->departement_id;
        $user->role_id = $request->role_id;
        $user->nom = $request->nom;
        $user->prenoms = $request->prenoms;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->contact = $request->contact;
        $user->adresse = $request->adresse;
        $user->genre = $request->genre;

        $user->save();

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur créé avec succès');
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
        $request->validate([
            'departement_id' => 'required|integer',
            'role_id' => 'required|integer',
            'nom' => 'required|string',
            'prenoms' => 'nullable|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'contact' => 'nullable|string',
            'adresse' => 'nullable|string',
            'genre' => 'nullable|string|in:Masculin,Feminin',
        ]);

        $user = User::findOrFail($id);

        $user->departement_id = $request->departement_id;
        $user->role_id = $request->role_id;
        $user->nom = $request->nom;
        $user->prenoms = $request->prenoms;
        $user->email = $request->email;

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->contact = $request->contact;
        $user->adresse = $request->adresse;
        $user->genre = $request->genre;

        $user->save();

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
