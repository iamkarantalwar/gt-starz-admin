<?php

namespace App\Models\Product;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    protected $guarded = ['created_at'];

    public $keyType = 'string';

    public function productValues()
    {
        return $this->hasMany(ProductSkuValue::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
