<?php

namespace App\Models\Product;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = ['created_at'];

    public $keyType = 'string';

    public function options()
    {
        return $this->hasMany(\App\Models\Product\ProductOption::class);
    }

    public function skus()
    {
        return $this->hasMany(ProductSku::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
