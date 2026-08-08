<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessEvenement extends Model
{
    use HasFactory;

    protected $table = 'access_evenements';

    protected $fillable = [
        'inscription_id',
        'reservation_id',
        'diffusion_id',
        'token',
        'date_expiration',
        'premiere_connexion',
        'derniere_connexion',
        'utilise',
        'adresse_ip',
        'user_agent',
    ];

    public function inscription()
    {
        return $this->belongsTo(InscriptionEvenement::class, 'inscription_id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function diffusion()
    {
        return $this->belongsTo(DiffusionEvenement::class, 'diffusion_id');
    }
}