<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['notification_type', 'message', 'notificationable_id', 'notificationable_type'];

    public function notificationable()
    {
        return $this->morphTo();
    }
}
