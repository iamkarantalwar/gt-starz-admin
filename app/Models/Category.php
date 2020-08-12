<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_name'];

    public $keyType = 'string';

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
