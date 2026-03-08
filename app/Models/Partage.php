<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partage extends Model
{
    protected $fillable = [
        'user_id',
        'favori_id',
        'destinataire_id',
    ];

    public function favori()
    {
        return $this->belongsTo(Favori::class);
    }

    public function expediteur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function destinataire()
    {
        return $this->belongsTo(User::class, 'destinataire_id');
    }
}
