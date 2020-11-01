<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

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

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('config.day_format'));
    }

    public function scopeName($query, $request)
    {
        if ($request->has('name') && $request->name != null) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        return $query;
    }

    public function scopePrice($query, $request)
    {
        if ($request->has('price_range') && $request->price_range != null) {
            $query->leftJoin('product_details', 'products.id', '=', 'product_details.product_id')
                ->groupBy('products.id')
                ->selectRaw('products.*, avg(product_details.price) AS `avg`')
                ->orderBy('avg', $request->price_range);
        }

        return $query;
    }
    public function scopeCategory($query, $request)
    {
        if ($request->has('category_id') && $request->category_id != null) {
            $query->where('category_id', $request->category_id);
        }

        return $query;
    }

    public function scopeType($query, $request)
    {
        if ($request->has('type') && $request->type != null) {
            if ($request->type == config('config.rate')) {
                $query->orderBy('rate','DESC');
            } else {
                if ($request->has('price_range') && $request->price_range == null) {
                    $query->leftJoin('product_details','products.id','=','product_details.product_id')
                        ->leftJoin('order_items','product_details.id','=','order_items.product_detail_id')
                        ->groupBy('products.id')
                        ->selectRaw('products.*, count(order_items.product_detail_id) AS `count`')
                        ->orderBy('count','DESC');
                } else {
                    $query->leftJoin('order_items','product_details.id','=','order_items.product_detail_id')
                        ->groupBy('products.id')
                        ->selectRaw('count(order_items.product_detail_id) AS `count`')
                        ->orderBy('count','DESC');
                }
            }
        }

        return $query;
    }

    public function scopeActive($query)
    {
        $query->where('status', config('config.default_one'))->where('block', config('config.default'));

        return $query;
    }
}
