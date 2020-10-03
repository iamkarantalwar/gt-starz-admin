<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'driver_id', 'name', 'address', 'city', 'state', 'phone_number', 'payment_type', 'order_status'];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }
}
