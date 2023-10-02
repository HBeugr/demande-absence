<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absence;
use App\Models\MotifAbsence;
use App\Models\StatutAbsence;
use App\Models\User;
use App\Notifications\NouvelDemande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

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
            ->orderBy('created_at', 'desc')
            ->get();
        $notifications = auth()->user()->unreadNotifications;

        return view('admin.pages.absence.index', compact('absences', 'motifs', 'statuts','notifications'));
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
        $user = Auth::user();
        // dd($user->role->etiquette);
        $currentMonth = date('Y-m');
        $startDate = $request->date_debut;
        $endDate = $request->date_fin;

        // Récupérez toutes les demandes d'absence approuvées des membres du même département
        $approvedAbsencesInSameDepartment = Absence::whereHas('user', function ($query) use ($user) {
            $query->where('departement_id', $user->departement_id);
        })
            ->where('statut_absence_id', StatutAbsence::where('nom', 'Approuvée')->first()->id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('date_debut', '<=', $startDate)
                        ->where('date_fin', '>=', $startDate);
                })
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('date_debut', '<=', $endDate)
                            ->where('date_fin', '>=', $endDate);
                    })
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('date_debut', '>=', $startDate)
                            ->where('date_fin', '<=', $endDate);
                    });
            })
            ->get();

        // Vérifiez si les dates de la nouvelle demande chevauchent des demandes approuvées existantes
        if (count($approvedAbsencesInSameDepartment) > 0) {
            return redirect()->back()->with('error', 'Les dates de votre demande d\'absence chevauchent des demandes approuvées d\'autres membres du même département.');
        }

        $dateDebut = Carbon::createFromFormat('Y-m-d', $request->input('date_debut'));
        $dateFin = Carbon::createFromFormat('Y-m-d', $request->input('date_fin'));

        // Récupérez le mois et l'année à partir des dates postées
        $mois = $dateDebut->month;
        // dd($mois);

        // Vérifiez si l'utilisateur a déjà 2 demandes ce mois-ci
        $absencesThisMonth = Absence::where('user_id', $user->id)
            ->whereMonth('date_debut', '=', $mois)
            ->get();

        if (count($absencesThisMonth) >= 2) {
            return redirect()->back()->with('error', 'Vous avez atteint la limite de 2 demandes d\'absence ce mois-ci.');
        }

        // Si les dates ne chevauchent aucune demande approuvée et que l'utilisateur n'a pas encore atteint la limite, continuez avec la création de la demande
        $request->validate([
            'statut_absence_id' => 'required|integer',
            'motif_absence_id' => 'required|integer',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $absence = new Absence([
            'user_id' => $user->id,
            'statut_absence_id' => $request->statut_absence_id,
            'motif_absence_id' => $request->motif_absence_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ]);

        $absence->save();

        if (strtolower($user->role->etiquette) == 'employé') {
            $administrators = User::whereHas('role', function ($query) {
                $query->where('etiquette', 'administrateur');
            })->pluck('id')->toArray();

            $departementId = $user->departement->id;

            $managersIds = User::whereHas('role', function ($query) {
                $query->where('etiquette', 'manager');
            })->whereHas('departement', function ($query) use ($departementId) {
                $query->where('id', $departementId);
            })->pluck('id')->toArray();
            $administratorsAndManagersIds = array_merge($administrators, $managersIds);
            $admins = User::whereIn('id', $administratorsAndManagersIds)->get();
            // dump($administrators, $managersIds);
            // dd('je suis la', $administratorsAndManagersIds, 'admin', $admins);

            Notification::send($admins, new NouvelDemande($absence));
        } elseif (strtolower($user->role->etiquette) == 'manager') {
            $administrators = User::whereHas('role', function ($query) {
                $query->where('etiquette', 'administrateur');
            })->pluck('id')->toArray();
            $admins = User::whereIn('id', $administrators)->get();
            Notification::send($admins, new NouvelDemande($absence));
        }


        return redirect()->back()->with('success', 'La demande d\'absence a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $motifs = MotifAbsence::all();
        $statuts = StatutAbsence::all();
        $user = auth()->user();

        $absence = Absence::find($id);
        $notifications = auth()->user()->unreadNotifications;

        return view('admin.pages.absence.show', compact('absence', 'motifs', 'statuts','notifications'));
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
