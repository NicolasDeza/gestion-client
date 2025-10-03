<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceChangee extends Model
{
    /** @use HasFactory<\Database\Factories\PieceChangeeFactory> */
    use HasFactory;

      protected $table = 'pieces_changees';

     protected $fillable = [
        'intervention_id',
        'nom_piece',
        'quantite',
        'prix_unitaire',
    ];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }
}

