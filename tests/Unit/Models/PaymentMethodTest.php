<?php


namespace Tests\Unit;

use App\Models\Order;
use App\Models\PaymentMethod;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new PaymentMethod();
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

    public function test_has_many_orders_relation()
    {
        $this->assertHasMany($this->model, 'orders', Order::class, 'payment_method_id', 'id');
    }
}
