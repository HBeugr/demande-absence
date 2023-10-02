<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        $notifications = auth()->user()->unreadNotifications;
        return view('admin.pages.client.index', compact('clients','notifications'));
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
            'prenoms' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:clients,email',
            'telephone' => 'required|string|max:20',
        ]);

        $client = new Client([
            'nom' => $request->input('nom'),
            'prenoms' => $request->input('prenoms'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
        ]);

        $client->save();

        return redirect()->route('clients.index')
            ->with('success', 'Le client a été créé avec succès.');
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
            'nom' => 'required|string|max:255',
            'prenoms' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:clients,email,' . $id,
            'telephone' => 'required|string|max:20',
        ]);

        $client = Client::find($id);

        if (!$client) {
            return redirect()->route('clients.index')
                ->with('error', 'Le client spécifié n\'existe pas.');
        }

        $client->nom = $request->input('nom');
        $client->prenoms = $request->input('prenoms');
        $client->email = $request->input('email');
        $client->telephone = $request->input('telephone');

        $client->save();

        return redirect()->route('clients.index')
            ->with('success', 'Le client a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::find($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès !');
    }
}
