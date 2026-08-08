<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

   protected $guarded = [''];

    public $timestamps = false;

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function submenus()
    {
        return $this->hasMany(Sousmenu::class, 'menu_id');
    }
}