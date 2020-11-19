<?php

namespace Tests\Unit;

use App\Models\Notification;
use App\Models\User;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Notification();
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
}
