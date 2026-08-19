<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Association extends Model
{
    use HasFactory;

    protected $table = 'associations';

    protected $fillable = [
        'nom',
        'logo',
        'historique',
        'mission',
        'vision',
        'description',
        'adresse',
        'telephone',
        'email',
        'facebook',
        'youtube',
        'instagram',
        'site_web',
        'actif',
    ];
}
