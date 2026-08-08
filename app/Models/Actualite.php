<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actualite extends Model
{
    use HasFactory;

    protected $table = 'actualites';

    protected $guarded = [''];

    public function images()
    {
        return $this->hasMany(ImageActualite::class);
    }
}