<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evenement extends Model
{
    use HasFactory;

    protected $table = 'evenements';

    protected $fillable = [
        'categorie_evenement_id',
        'titre',
        'description',
        'date_debut',
        'date_fin',
        'heure',
        'lieu',
        'actif',
    ];

    public function categorie()
    {
        return $this->belongsTo(CategorieEvenement::class, 'categorie_evenement_id');
    }

    public function category()
    {
        return $this->belongsTo(CategorieEvenement::class, 'categorie_evenement_id');
    }

    public function inscriptions()
    {
        return $this->hasMany(InscriptionEvenement::class, 'evenement_id');
    }

    public function diffusions()
    {
        return $this->hasMany(DiffusionEvenement::class, 'evenement_id');
    }

    public function images()
    {
        return $this->hasMany(ImageEvenement::class, 'evenement_id');
    }
}