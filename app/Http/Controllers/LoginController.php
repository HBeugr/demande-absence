<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Role;
use App\Models\User;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function authenticate(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            return redirect('accueil')->with('success', 'Bienvenue ' . $user->nom);
        } else {
            toastr()->error('Oops! Les informations d\'identification ne sont pas valides!');
            return redirect()->back()->withErrors(['message' => 'Les informations d\'identification ne sont pas valides.']);
        }
    }
    public function register(Request $request)
    {
        return view('register');
    }
    public function forgot_password()
    {
        return view('forgot-password');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
