<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    /** @use HasFactory<\Database\Factories\InterventionFactory> */
    use HasFactory;

     protected $fillable = [
        'machine_id',
        'date_intervention',
        'description',
        'quantite_huile',
        'statut_paiement',
        'montant',
    ];

     public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function piecesChangees() {
        return $this->hasMany(PieceChangee::class, 'intervention_id');
    }
}
