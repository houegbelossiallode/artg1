<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oeuvre extends Model
{
    use HasFactory;

    protected $table = 'oeuvres';

    protected $guarded = [''];

    public function talent()
    {
        return $this->belongsTo(Talent::class, 'talent_id');
    }
}