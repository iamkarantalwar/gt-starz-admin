<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $guarded = ['created_at'];

    public $keyType = 'string';

    public function values()
    {
      return $this->hasMany(ProductOptionValue::class, 'option_id');
    }
}
