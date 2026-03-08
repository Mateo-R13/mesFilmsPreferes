<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'password',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }

    public function amis()
    {
        return $this->hasMany(Ami::class);
    }

    public function partagesEnvoyes()
    {
        return $this->hasMany(Partage::class, 'user_id');
    }

    public function partagesRecus()
    {
        return $this->hasMany(Partage::class, 'destinataire_id');
    }
}
