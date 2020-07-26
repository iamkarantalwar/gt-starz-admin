<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['description', 'priority'];

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
