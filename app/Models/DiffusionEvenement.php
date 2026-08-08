<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiffusionEvenement extends Model
{
    use HasFactory;

    protected $table = 'diffusions_evenements';

    protected $fillable = [
        'evenement_id',
        'plateforme',
        'lien_reunion',
        'date_ouverture',
        'date_fermeture',
        'actif',
    ];

    public function event()
    {
        return $this->belongsTo(Evenement::class, 'evenement_id');
    }
}