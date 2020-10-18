<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute($value)
    {
        if ($value != null) {
            return asset(config('setting.image_folder') . $value);
        }

        return null;
    }
}
