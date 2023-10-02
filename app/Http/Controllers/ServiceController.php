<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        $notifications = auth()->user()->unreadNotifications;
        return view('admin.pages.service.index', compact('services','notifications'));
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
            'prix' => 'required|numeric',
        ]);

        Service::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
        ]);

        return redirect()->route('services.index')
            ->with('success', 'Le service a été créé avec succès.');
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
        $service = Service::find($id);

        if (!$service) {
            return redirect()->route('services.index')
                ->with('error', 'Service not found.');
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'nullable|numeric',
        ]);

        $service->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
        ]);

        return redirect()->route('services.index')
            ->with('success', 'Le service a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::find($id);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service supprimé avec succès !');
    }
}
