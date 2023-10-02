<?php

namespace App\Http\Controllers;

use App\Notifications\NouvelReponse;
use Carbon\Carbon;
use App\Models\Absence;
use App\Models\MotifAbsence;
use App\Models\StatutAbsence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class AbsenceListeController extends Controller
{
    public function getAll()
    {
        $motifs = MotifAbsence::all();
        $statuts = StatutAbsence::all();
        $notifications = auth()->user()->unreadNotifications;
        $absences = Absence::orderBy('created_at', 'desc')->get();
        return view('admin.pages.absence.liste', compact('absences', 'motifs', 'statuts', 'notifications'));
    }
    public function updateById(Request $request, string $id)
    {
        // Valider les données entrées par l'utilisateur
        $request->validate([
            'statut_absence_id' => 'required|integer',
            'motif_absence_id' => 'required|integer',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        // Utilisez la méthode "update" pour mettre à jour l'absence par ID
        Absence::where('id', $id)->update([
            'user_id' => $request->input('user_id'),
            'statut_absence_id' => $request->statut_absence_id,
            'motif_absence_id' => $request->motif_absence_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('liste')
            ->with('success', 'Demande d\'absence mise à jour avec succès.');
    }
    public function cancelById($id)
    {
        $user = Auth::user();
        $statut = StatutAbsence::where('nom', 'Annulée')->first();

        if ($statut) {
            $absence = Absence::find($id);

            if ($absence) {
                $absence->update([
                    'statut_absence_id' => $statut->id,
                    'cancelled_at' => now(),
                    'cancelled_by' => $user->id,
                ]);

                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'L\'absence n\'a pas été trouvée.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Le statut "Annulée" n\'a pas été trouvé.']);
        }
    }

    public function responseById(Request $request, $id)
    {
        $user = Auth::user();
        $statutApprouve = StatutAbsence::where('nom', 'Approuvée')->first();

        if (!$statutApprouve) {
            return redirect()->route('liste')->with('error', 'Le statut "Approuvée" n\'a pas été trouvé.');
        }

        $absence = Absence::find($id);

        if (!$absence) {
            return redirect()->route('liste')->with('error', 'La demande d\'absence n\'a pas été trouvée.');
        }

        $userId = $request->input('user_id');
        $userDemandeur = User::find($userId);

        if (!$userDemandeur) {
            return redirect()->route('liste')->with('error', 'L\'utilisateur demandeur n\'a pas été trouvé.');
        }

        $motifDemandeId = $request->input('motif_absence_id');
        $motif = MotifAbsence::where('nom', 'Congé de Décès')->first();

        $absences = Absence::whereHas('user', function ($query) use ($userDemandeur) {
            $query->where('departement_id', $userDemandeur->departement_id);
        })->where(function ($query) use ($statutApprouve) {
            $query->orWhereNotNull('reponse')
                ->orWhereNotNull('cancelled_at');
        })->where('statut_absence_id', '=', $statutApprouve->id)->get();

        $response = [
            'superieurId' => $user->id,
            'superieur' => $user->nom . ' ' . $user->prenoms,
        ];

        $jsonResponse = json_encode($response);

        if (count($absences) >= 3 && $motifDemandeId == $motif->id) {
            $absence->update([
                'statut_absence_id' => $request->input('statut_absence_id'),
                'reponse' => $jsonResponse,
            ]);

            $user = User::where('id', $userDemandeur->id)->get();
            Notification::send($user, new NouvelReponse($absence));

            return redirect()->route('liste')->with('success', 'Vous avez donné une réponse à la demande d\'Absence');
        } elseif (count($absences) >= 3 && strtolower($user->role->etiquette) !== 'administrateur') {
            $absence_non_valide = StatutAbsence::where('nom', 'Refusée')->first();

            $absence->update([
                'statut_absence_id' => $absence_non_valide ? $absence_non_valide->id : null,
                'reponse' => $jsonResponse,
            ]);

            $user = User::where('id', $userDemandeur->id)->get();
            Notification::send($user, new NouvelReponse($absence));

            return redirect()->route('liste')->with('success', 'La demande d\'absence a été refusée.');
        } else {
            $absence->update([
                'statut_absence_id' => $request->input('statut_absence_id'),
                'reponse' => $jsonResponse,
            ]);

            $user = User::where('id', $userDemandeur->id)->get();
            Notification::send($user, new NouvelReponse($absence));

            return redirect()->route('liste')->with('success', 'Vous avez donné une réponse à la demande d\'Absence');
        }
    }

    public function showResponse($id){
        $motifs = MotifAbsence::all();
        $statuts = StatutAbsence::all();
        $user = auth()->user();

        $absence = Absence::find($id);
        $notifications = auth()->user()->unreadNotifications;

        return view('admin.pages.absence.response', compact('absence', 'motifs', 'statuts','notifications'));
    }
}
