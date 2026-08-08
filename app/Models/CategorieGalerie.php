<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorieGalerie extends Model
{
    protected $table = 'categorie_galeries';
    protected $guarded = [];

    public function galeries()
    {
        return $this->hasMany(Galerie::class);
    }
}
