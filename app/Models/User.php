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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    // Amis que j'ai ajoutés
    public function amis()
    {
        return $this->hasMany(Ami::class, 'user_id');
    }

    // Partages envoyés
    public function partagesEnvoyes()
    {
        return $this->hasMany(Partage::class, 'expediteur_id');
    }

    // Partages reçus
    public function partagesRecus()
    {
        return $this->hasMany(Partage::class, 'destinataire_id');
    }
}
