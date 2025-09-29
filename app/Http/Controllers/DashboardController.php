<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Intervention;

class DashboardController extends Controller
{
    public function index()
    {
        $interventions = Intervention::with(['machine.client', 'machine.marque', 'machine.type'])
            ->latest()
            ->take(10)
            ->get();

        return Inertia::render('Dashboard', [
            'interventions' => $interventions,
        ]);
    }
}
