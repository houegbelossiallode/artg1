<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageActualite extends Model
{
    protected $guarded = [];

    public function actualite()
    {
        return $this->belongsTo(Actualite::class);
    }
}
