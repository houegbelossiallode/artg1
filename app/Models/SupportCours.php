<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportCours extends Model
{
    use HasFactory;

    protected $table = 'support_cours';

    protected $fillable = [
        'cours_id',
        'fichier',
        'type',
        'actif',
    ];

    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }
}