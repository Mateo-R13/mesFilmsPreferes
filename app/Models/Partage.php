<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partage extends Model
{
    protected $fillable = [
        'user_id',    // celui qui partage (migration)
        'ami_id',     // celui qui reçoit (migration)
        'favori_id',
        'message',
    ];

    public function favori()
    {
        return $this->belongsTo(Favori::class);
    }

    // Celui qui a partagé
    public function expediteur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Celui qui reçoit
    public function destinataire()
    {
        return $this->belongsTo(User::class, 'ami_id');
    }
}
