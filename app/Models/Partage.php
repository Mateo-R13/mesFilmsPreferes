<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partage extends Model
{
    protected $fillable = [
        'expediteur_id',   // ✅ corrigé : était 'user_id', ne matchait pas PartagesController
        'destinataire_id',
        'favori_id',
        'message',         // ✅ manquait dans fillable
    ];

    public function favori()
    {
        return $this->belongsTo(Favori::class);
    }

    public function expediteur()
    {
        return $this->belongsTo(User::class, 'expediteur_id');
    }

    public function destinataire()
    {
        return $this->belongsTo(User::class, 'destinataire_id');
    }
}
