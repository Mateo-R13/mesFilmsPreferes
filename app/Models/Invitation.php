<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'email',
        'message',
        'accepte',
    ];

    protected $casts = [
        'accepte' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
