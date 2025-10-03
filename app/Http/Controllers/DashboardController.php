<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Intervention;
use App\Models\Client;
use App\Models\Machine;

class DashboardController extends Controller
{
    public function index()
    {
        $interventions = Intervention::with(['machine.client', 'machine.marque', 'machine.machineType'])
            ->latest()
            ->take(15)
            ->get();

        // Compteurs pour les stats
        $clientsCount = Client::count();
        $machinesCount = Machine::count();

        return Inertia::render('Dashboard', [
            'interventions' => $interventions,
            'clientsCount' => $clientsCount,
            'machinesCount' => $machinesCount,
        ]);
    }
}
