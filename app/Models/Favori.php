<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tmdb_id',
        'titre',
        'synopsis',
        'affiche',
        'annee',
        'note_tmdb',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    public function monAvis()
    {
        return $this->hasOne(Avis::class)->where('user_id', auth()->id());
    }

    public function partages()
    {
        return $this->hasMany(Partage::class);
    }

    public function getAfficheUrlAttribute(): string
    {
        if ($this->affiche) {
            return 'https://image.tmdb.org/t/p/w500' . $this->affiche;
        }
        return 'https://via.placeholder.com/500x750/1a1a2e/e0b030?text=No+Image';
    }
}
