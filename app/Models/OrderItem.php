<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $table = 'order_items';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function productDeltail()
    {
        return $this->belongsTo(ProductDetail::class, 'product_detail_id', 'id')->withTrashed();
    }
}
