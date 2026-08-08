<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sousmenu extends Model
{
    use HasFactory;

    protected $table = 'sousmenus';

    protected $guarded = [''];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}