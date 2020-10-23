<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverRating extends Model
{
    protected $fillable = [
                            'driver_id',
                            'order_id',
                            'user_id',
                            'rating'
                        ];
}
