<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscriptionEvenement extends Model
{
    use HasFactory;

    protected $table = 'inscription_evenements';

    protected $fillable = [
        'evenement_id',
        'utilisateur_id',
        'date_inscription',
        'mode_paiement',
        'mode_id',
        'montant',
        'statut',
        'actif',
    ];

    public function event()
    {
        return $this->belongsTo(Evenement::class, 'evenement_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function mode()
    {
        return $this->belongsTo(Mode::class, 'mode_id');
    }

    public function payments()
    {
        return $this->hasMany(PaiementEvenement::class, 'inscription_id');
    }

    public function tickets()
    {
        return $this->hasMany(Billet::class, 'inscription_id');
    }
}