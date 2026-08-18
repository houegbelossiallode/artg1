<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $guarded = [];
    protected $fillable = [
        'cours_id',
        'user_id',
        'date_reservation',
        'heure_debut',
        'heure_fin',
        'disponibilite_id',
        'status',
        'report_proposed_at',
        'jitsi_room_id',
        'jitsi_room_password',
        'lien_replay',
        'description_replay'
    ];

    public function course()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function discussions()
    {
        return $this->hasMany(ReservationDiscussion::class);
    }

    public function disponibilite()
    {
        return $this->belongsTo(Disponibilite::class, 'disponibilite_id');
    }
}