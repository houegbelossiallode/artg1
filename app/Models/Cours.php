<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $table = 'cours';

    protected $fillable = [
        'categorie_cours_id',
        'user_id',
        'titre',
        'description',
        'tarif',
        'mode_id',
        'lieu',
        'actif',
    ];

    public function categorie()
    {
        return $this->belongsTo(CategorieCours::class, 'categorie_cours_id');
    }

    public function category()
    {
        return $this->belongsTo(CategorieCours::class, 'categorie_cours_id');
    }

    public function professeur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mode()
    {
        return $this->belongsTo(Mode::class, 'mode_id');
    }

    public function supports()
    {
        return $this->hasMany(SupportCours::class, 'cours_id');
    }
}