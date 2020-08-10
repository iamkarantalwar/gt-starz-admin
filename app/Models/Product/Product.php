<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['created_at'];

    protected $primaryKey = 'id';

    public $keyType = 'string';



    public function options()
    {
        return $this->hasMany(\App\Models\Product\ProductOption::class);
    }

    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }
}
