<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineType extends Model
{
    /** @use HasFactory<\Database\Factories\MachineTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'nom',
    ];
}
