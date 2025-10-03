<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InterventionController;
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
});

// Clients
Route::resource('clients', ClientController::class);

// Machines
Route::resource('machines', MachineController::class);

// Interventions
Route::resource('interventions', InterventionController::class);


