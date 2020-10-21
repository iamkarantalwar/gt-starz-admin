<?php

namespace App\Models\Order;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'driver_id', 'name', 'address', 'city', 'state', 'phone_number', 'payment_type', 'order_status', 'zip_code', 'lat', 'lng'];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class,  'driver_id');
    }
}
