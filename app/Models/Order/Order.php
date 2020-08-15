<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [];

    public function details()
    {
        return $this->hasMany(Order::class);
    }
}
