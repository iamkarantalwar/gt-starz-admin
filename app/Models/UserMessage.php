<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    protected $fillable = ['user_id', 'message', 'seen', 'message_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
