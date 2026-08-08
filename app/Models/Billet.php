<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billet extends Model
{
    use HasFactory;

    protected $table = 'billets';

    protected $fillable = [
        'inscription_id',
        'numero',
        'qr_code',
        'date_generation',
        'statut',
        'actif',
    ];

    public function inscription()
    {
        return $this->belongsTo(InscriptionEvenement::class, 'inscription_id');
    }
}