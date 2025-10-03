<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    /** @use HasFactory<\Database\Factories\MachineFactory> */
    use HasFactory;

     protected $fillable = [
        'client_id',
        'machine_type_id',
        'marque_id',
        'modele',
        'numero_serie',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

    public function machineType()
    {
        return $this->belongsTo(MachineType::class, 'machine_type_id');
    }

    // Alias pour la compatibilité
    public function type()
    {
        return $this->machineType();
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }
}
