<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    use HasFactory;

    protected $table = 'talents';

    protected $guarded = [''];

    public function categorie()
    {
        return $this->belongsTo(CategorieTalent::class, 'categorie_talent_id');
    }

    public function category()
    {
        return $this->belongsTo(CategorieTalent::class, 'categorie_talent_id');
    }

    public function oeuvres()
    {
        return $this->hasMany(Oeuvre::class, 'talent_id');
    }
}