<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Machine;
use App\Models\Intervention;
use App\Models\Marque;
use App\Models\MachineType;
use Illuminate\Support\Facades\DB;

class InterventionController extends Controller
{

    public function index() {
        $interventions = Intervention::with(['machine.client', 'machine.marque', 'machine.machine_type']) // ← machine_type
            ->latest()
            ->paginate(15);  // ← Remplacer take(15)->get() par paginate(15)

        return inertia('Interventions/Index', [
            'interventions' => $interventions
        ]);
    }

    public function show(Intervention $intervention)
{
    $intervention->load(['machine.client', 'machine.marque', 'machine.machine_type', 'piecesChangees']); // ← machine_type

    return inertia('Interventions/Show', [
        'intervention' => $intervention,
    ]);
}

    /**
     * Créer une intervention complète avec client et machine
     */
    public function createFull(Request $request)
    {
        \Log::info('createFull appelé avec:', $request->all());

        $request->validate([
            'client_nom' => 'required|string|max:255',
            'machine_marque' => 'required|string|max:255',
            'machine_type' => 'required|string|max:255',
            'date_intervention' => 'required|date',
            'statut' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // 1. Créer ou récupérer le client
            $client = Client::firstOrCreate(
                ['nom' => $request->client_nom],
                [
                    'email' => $request->client_email,
                    'telephone' => $request->client_telephone,
                    'adresse' => $request->client_adresse,
                ]
            );

            \Log::info('Client créé/trouvé:', $client->toArray());

            // 2. Créer ou récupérer la marque
            $marque = Marque::firstOrCreate(['nom' => $request->machine_marque]);

            // 3. Créer ou récupérer le type de machine
            $machineType = MachineType::firstOrCreate(['nom' => $request->machine_type]);

            // 4. Créer la machine
            $machine = Machine::create([
                'client_id' => $client->id,
                'marque_id' => $marque->id,
                'machine_type_id' => $machineType->id,
                'modele' => $request->machine_modele,
                'numero_serie' => $request->machine_numero_serie,
            ]);

            // 5. Créer l'intervention
            $intervention = Intervention::create([
                'machine_id' => $machine->id,
                'date_intervention' => $request->date_intervention,
                'description' => $request->description,
                'statut_paiement' => $request->statut === 'Payé' ? 'payé' : 'non payé',
                'montant' => $request->montant,
            ]);

            DB::commit();

            \Log::info('Intervention créée avec succès:', $intervention->toArray());

            // Retourner vers dashboard avec un message de succès
            return redirect()->route('dashboard')->with('success', 'Intervention créée avec succès !');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de la création:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Erreur lors de la création : ' . $e->getMessage()]);
        }
    }

    /**
     * Basculer le statut de paiement d'une intervention
     */
    public function togglePaiement(Request $request, Intervention $intervention)
    {
        $request->validate([
            'statut_paiement' => 'required|in:payé,non payé'
        ]);

        $intervention->update([
            'statut_paiement' => $request->statut_paiement
        ]);

        return redirect()->back();
    }

    public function storeForClient(Request $request, Client $client)
{
    $validated = $request->validate([
        'machine_marque' => 'required|string|max:255',
        'machine_type' => 'required|string|max:255',
        'machine_modele' => 'nullable|string|max:255',
        'machine_numero_serie' => 'nullable|string|max:255',
        'date_intervention' => 'required|date',
        'description' => 'nullable|string',
        'statut' => 'required|string',
        'montant' => 'nullable|numeric',
    ]);

    // Créer la machine associée
    $machine = $client->machines()->create([
        'marque_id' => Marque::firstOrCreate(['nom' => $validated['machine_marque']])->id,
        'machine_type_id' => MachineType::firstOrCreate(['nom' => $validated['machine_type']])->id,
        'modele' => $validated['machine_modele'] ?? null,
        'numero_serie' => $validated['machine_numero_serie'] ?? null,
    ]);

    // Créer l’intervention
    $machine->interventions()->create([
        'date_intervention' => $validated['date_intervention'],
        'description' => $validated['description'] ?? null,
        'statut' => $validated['statut'],
        'montant' => $validated['montant'] ?? null,
        'statut_paiement' => 'non payé',
    ]);

    return back()->with('success', 'Intervention ajoutée avec succès');
}
}

