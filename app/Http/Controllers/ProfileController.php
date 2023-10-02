<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = auth()->user()->unreadNotifications;
        return view('admin.pages.profile', compact('user', 'notifications'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Mettez à jour les informations du profil
        $user->nom = $request->input('nom');
        $user->prenoms = $request->input('prenoms');
        $user->date_Naissance = $request->input('date_naissance');
        $user->email = $request->input('email');
        $user->contact = $request->input('contact');
        $user->adresse = $request->input('adresse');
        $user->genre = $request->input('genre');

        // Enregistrez les modifications
        $user->save();

        // Redirigez l'utilisateur vers la page de profil avec un message de succès
        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès');
    }
    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->filled('old_password') && $request->filled('new_password')) {
            // Validez les champs de mot de passe
            $request->validate([
                'old_password' => 'required|string|min:8',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            // Vérifiez si l'ancien mot de passe correspond au mot de passe actuel
            if (password_verify($request->input('old_password'), $user->password)) {
                // Mettez à jour le mot de passe
                $user->password = bcrypt($request->input('new_password'));
            } else {
                // Redirigez l'utilisateur avec un message d'erreur si l'ancien mot de passe est incorrect
                return redirect()->back()->with('error', 'L\'ancien mot de passe est incorrect');
            }
        }

        // Enregistrez les modifications
        $user->save();

        // Déconnectez l'utilisateur s'il a mis à jour son mot de passe
        if ($request->filled('old_password') && $request->filled('new_password')) {
            auth()->logout();
            return redirect()->route('login')->with('success', 'Votre mot de passe a été modifié. Veuillez vous reconnecter.');
        }
    }
}
