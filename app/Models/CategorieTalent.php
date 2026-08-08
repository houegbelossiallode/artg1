<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieTalent extends Model
{
    use HasFactory;

    protected $table = 'categorie_talents';

    protected $fillable = [
        'libelle',
        'actif',
    ];

    public $timestamps = false;
}