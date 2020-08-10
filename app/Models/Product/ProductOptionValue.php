<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{

    protected $primaryKey = 'id';

    protected $guarded = ['created_at'];
}
