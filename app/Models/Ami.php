<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ami extends Model
{
    protected $table = 'amis';

    protected $fillable = [
        'user_id',
        'ami_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ami()
    {
        return $this->belongsTo(User::class, 'ami_id');
    }
}
