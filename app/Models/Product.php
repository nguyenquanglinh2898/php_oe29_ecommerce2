<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getThumbnailAttribute($value)
    {
        if ($value == null) {
            return asset(config('setting.default_product_thumbnail'));
        }

        return asset(config('setting.image_folder') . $value);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('setting.date_format'));
    }
}
