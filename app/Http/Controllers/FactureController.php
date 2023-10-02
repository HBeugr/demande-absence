<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Facture;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function show($id)
    {
        $commande = Commande::where('id', $id)->first();
        $facture = $commande->facture;
        $notifications = auth()->user()->unreadNotifications;
        // Vérifiez si la facture existe
        if ($facture) {
            // Retournez la vue de la facture avec les données de la facture
            return view('admin.pages.commande.facture', compact('facture','notifications'));
        } else {
            // Gérez le cas où la facture n'existe pas
            return redirect()->route('commandes.index')->with('error', 'Facture non trouvée.');
        }
    }
}
