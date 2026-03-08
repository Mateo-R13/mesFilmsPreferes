<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    protected $fillable = [
        'user_id',
        'tmdb_id',
        'titre',
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
        return $this->hasOne(Avis::class);
    }

    public function partages()
    {
        return $this->hasMany(Partage::class);
    }
}
