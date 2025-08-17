<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerifyOTPController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\BranchesController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\UserController; // Ensure this controller exists in the specified namespace
use Illuminate\Support\Facades\Route;
// routes/web.php
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\CaissesController;
use App\Http\Controllers\ServicesController;

Route::get('/', function () {
    return redirect()->route('login');
});
// routes/web.php
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');
// // Route pour rediriger vers Google
// Route::get('/auth/google/redirect', [SocialiteController::class, 'redirect'])->name('google.redirect');
// // Route que Google appellera après authentification
// Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])->name('google.callback');

// // --- Facebook Routes (nouvelles) ---
// Route::get('/auth/facebook/redirect', [SocialiteController::class, 'redirect'])->name('facebook.redirect');
// Route::get('/auth/facebook/callback', [SocialiteController::class, 'callback'])->name('facebook.callback');

// --- Routes pour la vérification OTP ---
Route::post('/verifi-numero', [VerifyOTPController::class, 'verifiNumero'])->name('verifi-numero');
Route::get('/verifi-otp', [VerifyOTPController::class, 'verifiOTP'])->name('verifi-otp');
Route::post('/verification-otp/resend', [VerifyOTPController::class, 'resendCode'])->name('verificationOTP.resend');
Route::post('/verification-otp', [VerifyOTPController::class, 'verifyCode'])->name('verificationOTP.check');
Route::get('/mot-de-passe', [VerifyOTPController::class, 'motpasse'])->name('mot-de-passe');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/caisses', [CaissesController::class, 'index'])->name('caisse.index');
    Route::get('/agents', [AgentController::class, 'index'])->name('agent.index');
    // Création d’une caisse
    Route::post('/caisses', [CaissesController::class, 'store'])->name('caisses.store');

    // Mise à jour d’une caisse (AJAX, PATCH/PUT)
    Route::patch('/caisses/{caisse}', [CaissesController::class, 'update'])->name('caisses.update');
    Route::put('/caisses/{caisse}', [CaissesController::class, 'update']); // optionnel si tu veux aussi accepter PUT

    // Suppression d’une caisse (AJAX)
    Route::delete('/caisses/{caisse}', [CaissesController::class, 'destroy'])->name('caisses.destroy');


    Route::get('/branches', [BranchesController::class, 'index'])->name('branche.index');
    // Le nom {structure} est crucial. S'il s'appelle {id} ou {structure_id}, ça ne marchera pas.
    Route::post('/structures/{structure}/branches', [BranchesController::class, 'store'])->name('branches.store');
    // Modification (update via AJAX ou formulaire)
    Route::patch('/branches/{branche}', [BranchesController::class, 'update'])->name('branches.update');
    Route::put('/branches/{branche}', [BranchesController::class, 'update']); // optionnel
    // Suppression (via AJAX ou bouton)
    Route::delete('/branches/{branche}', [BranchesController::class, 'destroy'])->name('branches.destroy');


    Route::get('/services', [ServicesController::class, 'index'])->name('service.index');
    Route::post('/services', [ServicesController::class, 'store'])->name('services.store');
    Route::patch('/services/{service}', [ServicesController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServicesController::class, 'destroy'])->name('services.destroy');
});

require __DIR__ . '/auth.php';
