<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Transporter;
use App\Models\User;
use App\Models\Voucher;
use Tests\TestCase;

class OrderTest extends TestCase
{
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Order();
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

    public function test_belongs_to_user_relation()
    {
        $this->assertBelongsTo($this->model, 'user', User::class, 'user_id', 'id');
    }

    public function test_belongs_to_voucher_relation()
    {
        $this->assertBelongsTo($this->model, 'voucher', Voucher::class, 'voucher_id', 'id');
    }

    public function test_belongs_to_payment_method_relation()
    {
        $this->assertBelongsTo($this->model, 'paymentMethod', PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function test_belongs_to_transporter_relation()
    {
        $this->assertBelongsTo($this->model, 'transporter', Transporter::class, 'transporter_id', 'id');
    }

    public function test_has_many_order_items_relation()
    {
        $this->assertHasMany($this->model, 'orderItems', OrderItem::class, 'order_id', 'id');
    }
}
