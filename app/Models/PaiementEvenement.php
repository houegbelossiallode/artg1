<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaiementEvenement extends Model
{
    use HasFactory;

    protected $table = 'paiement_evenements';

    protected $guarded = [''];

    public $timestamps = false;

    public function inscription()
    {
        return $this->belongsTo(InscriptionEvenement::class, 'inscription_id');
    }
}