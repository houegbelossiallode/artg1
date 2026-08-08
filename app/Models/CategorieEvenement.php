<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieEvenement extends Model
{
    use HasFactory;

    protected $table = 'categorie_evenements';

    protected $fillable = [
        'libelle',
        'actif',
    ];

    public $timestamps = false;
}