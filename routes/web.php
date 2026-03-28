<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

// Page de login simplifiée
Route::get('/login', function () {
    return '
    <form method="POST" action="/login" style="max-width:300px;margin:50px auto;font-family:sans-serif;">
        '.csrf_field().'
        <h2>Connexion Parking</h2>
        <input type="email" name="email" placeholder="Email" required style="width:100%;margin-bottom:10px;padding:8px;"><br>
        <input type="password" name="password" placeholder="Mot de passe" required style="width:100%;margin-bottom:10px;padding:8px;"><br>
        <button type="submit" style="width:100%;padding:10px;background:#3b82f6;color:white;border:none;border-radius:4px;cursor:pointer;">Se connecter</button>
    </form>
    ';
})->name('login');

// Logique de traitement du login
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/utilisateurs');
    }

    return back()->withErrors(['email' => 'Identifiants incorrects.']);
});

// Route de déconnexion [cite: 11]
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Routes protégées pour l'Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/utilisateurs', [AdminController::class, 'indexUtilisateurs'])->name('admin.users');
    Route::post('/admin/utilisateurs/valider/{id}', [AdminController::class, 'validerUtilisateur'])->name('admin.user.validate');
    Route::get('/admin/attente', [AdminController::class, 'indexAttente'])->name('admin.waiting');
    Route::post('/admin/attente/retirer/{id}', [App\Http\Controllers\AdminController::class, 'retirerAttente'])->name('admin.attente.retirer');
});

// Afficher le Dashboard (Espace utilisateur)
Route::get('/dashboard', function () {
    $reservation = DB::table('reservations')
        ->join('places', 'reservations.place_id', '=', 'places.id')
        ->where('user_id', Auth::id())
        ->select('places.numero')
        ->first();

    return view('dashboard', ['maPlace' => $reservation ? $reservation->numero : 'Aucune']);
})->middleware('auth')->name('dashboard');
// Action du bouton de réservation
Route::post('/reservation/demande', [App\Http\Controllers\ReservationController::class, 'demander'])->name('reservation.demande');