<?php

namespace App\Models\Product;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    protected $guarded = ['created_at'];

    public function productValues()
    {
        return $this->hasMany(ProductSkuValue::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
