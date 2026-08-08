<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageEvenement extends Model
{
    protected $guarded = [];

    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }
}
