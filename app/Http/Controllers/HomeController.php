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
use Illuminate\Support\Facades\DB;

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
        $departements = Departement::all();
        $notifications = auth()->user()->unreadNotifications;
        $absences = Absence::whereMonth('date_debut', now()->month)->get();
        return view(
            'admin.dashboard',
            compact(
                'user',
                'users',
                'roles',
                'clients',
                'absences',
                'services',
                'factures',
                'commandes',
                'notifications',
                'departements',
            )
        );
    }
    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }
    public function markAsRead($id)
    {
        $user = Auth::user();

        // Marquez la notification de l'utilisateur actuel comme lue
        $user->unreadNotifications->where('id', $id)->markAsRead();

        // Récupérez la donnée (data) de la notification de l'utilisateur actuel
        $notification = DB::table('notifications')->where('id', $id)->first();
        $dataToMatch = $notification->data;

        // Marquez comme lues les autres notifications de l'utilisateur actuel ayant la même donnée
        $user->unreadNotifications->filter(function ($notification) use ($dataToMatch) {
            return $notification->data === $dataToMatch;
        })->markAsRead();

        // Récupérez toutes les notifications non lues ayant la même donnée (data)
        $unreadNotificationsWithSameData = DB::table('notifications')
            ->whereNull('read_at')
            ->where('data', '=', $dataToMatch)
            ->get();

        // Marquez comme lues les autres notifications ayant la même donnée
        foreach ($unreadNotificationsWithSameData as $notification) {
            DB::table('notifications')->where('id', $notification->id)->update(['read_at' => now()]);
        }

        return response()->noContent();
    }
}
