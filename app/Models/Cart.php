<?php

namespace App\Models;
use Illuminate\Support\Collection;
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

    public function add($item)
    {
        if (Arr::exists($this->items, $item['id'])) {
            if ($this->items[$item['id']]['qty'] < $item['remaining']) {
                $this->items[$item['id']]['qty'] += 1;
                $this->totalQty += 1;
                $this->totalPrice += $item['price'];
                $this->totalWeight += $item['product']['weight'];

                return true;
            }

           return false;
        } else {
            Arr::set($item, 'qty', 1);
            $this->items = Arr::add($this->items, $item['id'], $item);
            $this->totalQty += 1;
            $this->totalPrice += $item['price'];
            $this->totalWeight += $item['product']['weight'];

            return true;
        }
    }

    public function update($item, $qty)
    {
        if (Arr::exists($this->items, $item['id'])) {
            if ($qty <= $item['remaining'] && $qty >= 1 ) {
                $this->totalQty += ($qty - $this->items[$item['id']]['qty']);
                $this->totalPrice += ($qty - $this->items[$item['id']]['qty']) * $item['price'];
                $this->totalWeight += ($qty - $this->items[$item['id']]['qty']) * $item['product']['weight'];
                $this->items[$item['id']]['qty'] = $qty;

                return true;
            }
        }

        return false;
    }

    public function remove($item)
    {
        if (Arr::exists($this->items, $item['id'])) {
            $this->totalQty -= $this->items[$item['id']]['qty'];
            $this->totalPrice -= $this->items[$item['id']]['qty'] * $item['price'];
            $this->totalWeight -= $this->items[$item['id']]['qty'] * $item['product']['weight'];
            Arr::forget($this->items, $item['id']);

            return true;
        }

        return false;
    }
}
