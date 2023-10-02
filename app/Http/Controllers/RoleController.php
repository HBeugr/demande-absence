<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $notifications = auth()->user()->unreadNotifications;
        return view('admin.pages.role.index', compact('roles', 'notifications'));
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
            'etiquette' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Role::create([
            'etiquette' => $request->etiquette,
            'description' => $request->description,
        ]);

        return redirect()->route('roles.index')
            ->with('success', 'Le rôle a été créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
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
        $role = Role::find($id);

        $validatedData = $request->validate([
            'etiquette' => 'string|unique:roles,etiquette,' . $role->id . '|max:255',
            'description' => 'nullable|string',
        ]);

        $role->update($validatedData);

        return redirect(route('roles.index'))->with('success', 'Le role a été mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role supprimé avec succès !');
    }
}
