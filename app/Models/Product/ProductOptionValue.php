<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    public $keyType = 'string';

    protected $primaryKey = 'id';

    protected $guarded = ['created_at'];
}
