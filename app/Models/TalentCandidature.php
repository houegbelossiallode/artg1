<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TalentCandidature extends Model
{
    protected $table = 'talent_candidatures';

    protected $fillable = [
        'nom',
        'prenom',
        'pseudo',
        'age',
        'discipline_id',
        'demo_link',
        'presentation',
        'email',
        'telephone',
        'whatsapp',
        'statut',
    ];

    public function discipline()
    {
        return $this->belongsTo(Discipline::class, 'discipline_id');
    }
}
