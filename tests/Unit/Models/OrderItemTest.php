<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductDetail;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new OrderItem();
    }

    protected function tearDown(): void
    {
        unset($this->model);
        parent::tearDown();
    }

    public function test_contains_valid_guarded_properties()
    {
        $this->assertEquals([], $this->model->getGuarded());
    }

    public function test_belongs_to_order_relation()
    {
        $this->assertBelongsTo($this->model, 'order', Order::class, 'order_id', 'id');
    }

    public function test_belongs_to_product_detail_relation()
    {
        $this->assertBelongsTo($this->model, 'productDeltail', ProductDetail::class, 'product_detail_id', 'id');
    }
}
