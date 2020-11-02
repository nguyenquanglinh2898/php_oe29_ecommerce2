<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

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
