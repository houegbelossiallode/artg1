<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Reservation;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'email',
        'password',
        'prenom',
        'photo',
        'sexe',
        'date_naissance',
        'biographie',
        'telephone',
        'adresse',
        'profil_id',
        'actif',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Accessor for full name ($user->name)
     */
    public function getNameAttribute(): string
    {
        return trim(($this->prenom ?? '') . ' ' . ($this->nom ?? ''));
    }

    public function profil()
    {
        return $this->belongsTo(Profil::class, 'profil_id');
    }
    /**
    * Reservations made by the user (student or professor)
    */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
 * Send the password reset notification.
 */
public function sendPasswordResetNotification($token)
{
    $url = url(route('password.reset', ['token' => $token, 'email' => $this->email], false));
    $this->notify(new \App\Notifications\PasswordResetNotification($url));
}
}

