<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductSkuValue extends Model
{
    protected $guarded = ['created_at'];

    public $keyType = 'string';

    public function productOption()
    {
        return $this->belongsTo(Option::class, 'product_option_id');
    }

}
