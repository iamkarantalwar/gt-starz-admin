<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category_name'];

    public $keyType = 'string';

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
