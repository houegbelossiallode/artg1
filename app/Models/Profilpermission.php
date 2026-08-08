<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profilpermission extends Model
{
    use HasFactory;

    protected $table = 'profilpermissions';

    protected $guarded = [''];

    public function profile()
    {
        return $this->belongsTo(Profil::class, 'profil_id');
    }

    public function submenu()
    {
        return $this->belongsTo(Sousmenu::class, 'sousmenu_id');
    }
}