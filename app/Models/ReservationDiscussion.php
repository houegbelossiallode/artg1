<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationDiscussion extends Model
{
    protected $fillable = [
        'reservation_id',
        'sender_id',
        'message',
        'proposed_date',
        'proposed_start_time',
        'proposed_end_time',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
