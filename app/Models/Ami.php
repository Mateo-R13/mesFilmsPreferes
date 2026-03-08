<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ami extends Model
{
    protected $table = 'amis';

    protected $fillable = [
        'user_id',
        'friend_id', // ✅ vrai nom de colonne dans la migration
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ami()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }
}
