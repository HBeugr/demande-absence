<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AbsenceListeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MotifAbsenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StatutAbsenceController;
use App\Http\Controllers\UserController;

Route::get('/',[LoginController::class, 'login'])->name('login')->middleware('isDisLogged');
Route::get('inscription',[LoginController::class, 'register'])->name('register');
Route::post('authentification',[LoginController::class, 'authenticate'])->name('authenticate');
Route::get('mot-de-passe-oublié',[LoginController::class, 'forgot_password'])->name('forgot-password');


Route::middleware(['isLogged', 'auth'])->group(function () {
    Route::get('accueil', [HomeController::class, 'home'])->name('accueil');
    Route::post('/mark-as-read', 'HomeController@markNotification')->name('markNotification');
        Route::get('/lecture/{id}', [HomeController::class, 'markAsRead'])->name('mark-as-read');

    Route::get('deconnexion',[LoginController::class,'logout'])->name('deconnexion');

    Route::resource('roles', RoleController::class);//verifié
    Route::resource('clients', ClientController::class);//verifié
    Route::resource('absences', AbsenceController::class);//verifié
    Route::resource('services', ServiceController::class);//verifié
    Route::resource('utilisateurs', UserController::class);//verifié
    Route::resource('commandes', CommandeController::class);//verifié
    Route::resource('motifs', MotifAbsenceController::class);//verifié
    Route::resource('statuts', StatutAbsenceController::class);//verifié
    Route::resource('departements', DepartementController::class);//verifié

    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update/{id}', [ProfileController::class, 'update'])->name('updateProfile');
    Route::put('/mot-de-passe/update/{id}', [ProfileController::class, 'updatePassword'])->name('updatePassword');

    Route::get('liste', [AbsenceListeController::class, 'getAll'])->name('liste');
    Route::get('/facture/{id}', [FactureController::class, 'show'])->name('facture.show');//verifié
    Route::put('update/{absence}', [AbsenceListeController::class, 'updateById'])->name('updateAbsence');
    Route::put('cancel/{absence}', [AbsenceListeController::class, 'cancelById'])->name('cancelAbsence');
    Route::put('response/{absence}', [AbsenceListeController::class, 'responseById'])->name('responseAbsence');
    Route::get('/reponse-absence/{absence}', [AbsenceListeController::class, 'showResponse'])->name('showResponse');
});
