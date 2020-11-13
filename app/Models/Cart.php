<?php

namespace App\Models;
use Illuminate\Support\Arr;

class Cart
{
    private $items = [];
    private $totalQty = 0;
    private $totalPrice = 0;
    private $totalWeight = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
            $this->totalWeight = $oldCart->totalWeight;
        }
    }

    public function __get($key)
    {
        return $this->$key;
    }

    public function __set($key, $value)
    {
        $this->$key = $value;
    }
}
