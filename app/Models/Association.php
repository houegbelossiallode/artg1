<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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