<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galerie extends Model
{
    protected $guarded = [];

    public function categorie()
    {
        return $this->belongsTo(CategorieGalerie::class, 'categorie_galerie_id');
    }
}
