<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['description', 'priority', 'category_id'];

    public $keyType = 'string';

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
