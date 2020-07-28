<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $guarded = ['created_at'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
