<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\PieceChangeeController;
use App\Http\Controllers\ClientController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Route pour créer tout en une fois
    Route::post('/interventions/create-full', [App\Http\Controllers\InterventionController::class, 'createFull'])->name('interventions.create-full');

    // Route pour basculer le statut de paiement
    Route::patch('/interventions/{intervention}/toggle-paiement', [App\Http\Controllers\InterventionController::class, 'togglePaiement'])->name('interventions.toggle-paiement');

    // Routes pour les pièces changées
    Route::post('/pieces', [PieceChangeeController::class, 'store'])->name('pieces.store');
    Route::delete('/pieces/{piece}', [PieceChangeeController::class, 'destroy'])->name('pieces.destroy');
});

// Clients
Route::resource('clients', ClientController::class);
Route::get('/clients/{client}/intervention/create', [ClientController::class, 'createIntervention'])
    ->name('clients.intervention.create');
Route::post('/clients/{client}/interventions', [InterventionController::class, 'storeForClient'])
    ->name('interventions.storeForClient');


// Machines
Route::resource('machines', MachineController::class);

// Interventions
Route::resource('interventions', InterventionController::class);


