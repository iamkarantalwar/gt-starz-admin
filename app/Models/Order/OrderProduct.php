<?php

namespace App\Models\Order;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = ['order_id', 'product_id','category_name', 'product_name', 'cost', 'discount', 'total', 'quantity', 'variation_type', 'variation_value'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
