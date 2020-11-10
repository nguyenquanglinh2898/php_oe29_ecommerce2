<?php

namespace Tests\Unit;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class RoleTest extends TestCase
{
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Role();
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

    public function test_belongs_to_many_permission_relation()
    {
        $this->assertBelongsToMany($this->model, 'permissions', Permission::class, 'role_id', 'permission_id');
    }

    public function test_has_many_user_relation()
    {
        $this->assertHasMany($this->model, 'users', User::class, 'role_id', 'id');
    }
}
