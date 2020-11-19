<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use App\Models\Transporter;
use Tests\TestCase;

class TransporterTest extends TestCase
{
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Transporter();
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

    public function test_has_many_products_relation()
    {
        $this->assertHasMany($this->model, 'orders',Order::class, 'transporter_id', 'id');
    }
}
