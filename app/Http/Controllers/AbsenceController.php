<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absence;
use App\Models\MotifAbsence;
use App\Models\StatutAbsence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motifs = MotifAbsence::all();
        $statuts = StatutAbsence::all();
        $user = auth()->user();

        // Récupérez les absences correspondant à l'utilisateur connecté
        $absences = Absence::where('user_id', $user->id)
            ->orderBy('date_debut', 'desc')
            ->get();

        return view('admin.pages.absence.index', compact('absences', 'motifs', 'statuts'));
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
            'statut_absence_id' => 'required|integer', // Assurez-vous que statut_absence_id est lié à l'état actuel de la demande
            'motif_absence_id' => 'required|integer',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $user = Auth::user();
        // Créer une nouvelle instance d'Absence
        $absence = new Absence([
            'user_id' => $user->id,
            'statut_absence_id' => $request->statut_absence_id,
            'motif_absence_id' => $request->motif_absence_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ]);

        // Enregistrer l' Demande d\'absence dans la base de données
        $absence->save();

        // Rediriger avec un message de succès
        return redirect()->route('absences.index')
            ->with('success', ' Demande d\'absence créée avec succès.');
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
        $user = Auth::user();
        // Valider les données entrées par l'utilisateur
        $request->validate([
            'statut_absence_id' => 'required|integer',
            'motif_absence_id' => 'required|integer',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        // Utilisez la méthode "update" pour mettre à jour l'absence par ID
        Absence::where('id', $id)->update([
            'user_id' => $user->id,
            'statut_absence_id' => $request->statut_absence_id,
            'motif_absence_id' => $request->motif_absence_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('absences.index')
            ->with('success', 'Demande d\'absence mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absence = Absence::find($id);
        $absence->delete();

        return redirect()->route('absences.index')->with('success', 'Demande d\'absence supprimée avec succès !');
    }
}
