<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = ['order_id', 'category_name', 'product_name', 'cost', 'discount', 'total', 'quantity'];
}
