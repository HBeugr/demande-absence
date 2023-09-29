<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Departement;
use App\Models\Facture;
use App\Models\Livraison;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $users = User::all();
        $roles = Role::all();
        $clients = Client::all();
        $services = Service::all();
        $factures = Facture::all();
        $commandes = Commande::all();
        $livraisons = Livraison::all();
        $departements = Departement::all();
        $absences = Absence::whereMonth('date_debut', now()->month)->get();
        return view('admin.dashboard',
            compact(
                'user',
                'users',
                'roles',
                'clients',
                'absences',
                'services',
                'factures',
                'commandes',
                'livraisons',
                'departements',
            )
        );
    }
}
