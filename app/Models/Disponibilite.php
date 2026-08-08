<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disponibilite extends Model
{
    use HasFactory;

    protected $table = 'disponibilites';

    protected $fillable = [
        'professeur_id',
        'jour',
        'debut',
        'fin',
        'statut',
        'actif',
    ];



    public function teacher()
    {
        return $this->belongsTo(User::class, 'professeur_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'disponibilite_id');
    }
}