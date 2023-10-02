<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Facture;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Validator;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = Commande::with('user', 'services')->get();
        $clients = Client::all();
        $services = Service::all();
        $user = Auth::user();
        $notifications = auth()->user()->unreadNotifications;

        return view('admin.pages.commande.index', compact('commandes', 'clients', 'services','user', 'notifications'));
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
            'quantite' => 'required',
            'client_id' => 'required',
            'service_id' => 'required',
        ]);
        $userId = auth()->user()->id;
        // Créer une nouvelle commande
        $commande = new Commande([
            'user_id' => $userId,
            'client_id' => $request->input('client_id'),
        ]);
        $commande->save();

        $services[] = $request->input('service_id');
        $quantites[] = $request->input('quantite');
        // dd($services, $quantites);
        // Assurez-vous que les tableaux 'service_id' et 'quantite' ont la même longueur
        if (count($services) === count($quantites)) {
            for ($i = 0; $i < count($services); $i++) {
                $serviceId = $services[$i];
                $quantite = $quantites[$i];

                // Attachez le service à la commande avec la quantité spécifiée
                $commande->services()->attach($serviceId, ['quantite' => $quantite]);
            }
        }
        $service = Service::find($request->input('service_id'));
        $montant_facture = (int)$request->input('quantite') * (int)$service->prix;
        // $date = date('Y-m-d');
        // dd($date);
        $facture = new Facture([
            'date_facture' => date('Y-m-d'),
            'numero_facture' => Uuid::uuid4()->toString(),
            'montant_facture' => $montant_facture,
            'commande_id' => $commande->id,
        ]);
        $facture->save();

        return redirect()->route('commandes.index')
            ->with('success', 'Commande créée avec succès.');
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
        $validator = Validator::make($request->all(), [
            'quantite' => 'required',
            'client_id' => 'required',
            'service_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Récupérez la commande à mettre à jour
        $commande = Commande::find($id);

        if (!$commande) {
            return redirect()->route('commandes.index')
                ->with('error', 'Commande non trouvée.');
        }

        $userId = auth()->user()->id;

        // Mettez à jour la commande avec les nouvelles données
        $commande->update([
            'user_id' => $userId,
            'client_id' => $request->input('client_id'),
        ]);

        $serviceId = $request->input('service_id');
        $quantite = $request->input('quantite');

        // Assurez-vous que les tableaux 'service_id' et 'quantite' ont la même longueur
        if (is_array($serviceId) && is_array($quantite) && count($serviceId) === count($quantite)) {
            // Supprimez d'abord tous les services associés à la commande existante
            $commande->services()->detach();

            for ($i = 0; $i < count($serviceId); $i++) {
                $serviceIdSingle = $serviceId[$i];
                $quantiteSingle = $quantite[$i];

                // Attachez le service à la commande avec la quantité spécifiée
                $commande->services()->attach($serviceIdSingle, ['quantite' => $quantiteSingle]);
            }
        }

        // Recherchez la facture associée à cette commande, ou créez-la si elle n'existe pas encore
        $facture = Facture::where('commande_id', $commande->id)->first();

        if (!$facture) {
            // Si la facture n'existe pas, créez-la
            $service = Service::find($serviceId[0]); // Par exemple, prenez le premier service pour calculer le montant

            $montant_facture = (int)$quantite[0] * (int)$service->prix;

            $facture = new Facture([
                'date_facture' => now(),
                'numero_facture' => Uuid::uuid4()->toString(),
                'montant_facture' => $montant_facture,
                'commande_id' => $commande->id,
            ]);

            $facture->save();
        } else {
            // Si la facture existe, mettez à jour son montant (par exemple, en prenant le montant du premier service)
            $service = Service::find($serviceId[0]);

            $montant_facture = (int)$quantite[0] * (int)$service->prix;

            $facture->update([
                'montant_facture' => $montant_facture,
            ]);
        }

        return redirect()->route('commandes.index')->with('success', 'Commande mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
