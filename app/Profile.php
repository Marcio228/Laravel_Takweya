<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id', 'telegram_id', 'phone'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
