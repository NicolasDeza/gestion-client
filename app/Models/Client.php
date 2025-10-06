<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
    ];

    // 🔹 Un client possède plusieurs machines
    public function machines()
    {
        return $this->hasMany(Machine::class);
    }

    // 🔹 Un client possède plusieurs interventions à travers ses machines
    public function interventions()
    {
        return $this->hasManyThrough(
            Intervention::class,  // modèle final
            Machine::class,       // modèle intermédiaire
            'client_id',          // clé étrangère dans machines
            'machine_id',         // clé étrangère dans interventions
            'id',                 // clé primaire dans clients
            'id'                  // clé primaire dans machines
        );
    }
}
