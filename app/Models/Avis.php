<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = [
        'favori_id',
        'user_id',
        'note',
        'commentaire',
    ];

    public function favori()
    {
        return $this->belongsTo(Favori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
