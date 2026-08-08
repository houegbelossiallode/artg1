<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Don extends Model
{
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'montant',
        'mode_paiement',
        'message',
        'anonyme',
        'statut',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'anonyme' => 'boolean',
    ];
}
