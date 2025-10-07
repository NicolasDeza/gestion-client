<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $clients = Client::with([
        'machines.marque',
        'machines.machine_type',
    ])
    ->withCount(['machines', 'interventions'])
    ->orderBy('nom')
    ->paginate(15); // 

        return Inertia::render('Clients/Index', [
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
{
    $client->load([
        'machines.marque',
        'machines.machineType',
        'machines.interventions' => fn($q) => $q->latest(),
    ]);

    return inertia('Clients/Show', [
        'client' => $client,
    ]);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }

    public function createIntervention(Client $client)
{
    $client->load('machines');
    return Inertia::render('Clients/InterventionCreate', [
        'client' => $client,
    ]);
}

}
