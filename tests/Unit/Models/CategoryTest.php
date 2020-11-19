<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Category();
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
        $this->assertHasMany($this->model, 'products',Product::class, 'category_id', 'id');
    }

    public function test_has_many_children_relation()
    {
        $this->assertHasMany($this->model, 'children',Category::class, 'parent_id', 'id');
    }

    public function test_belongs_to_parent_relation()
    {
        $this->assertBelongsTo($this->model, 'parent', Category::class, 'parent_id', 'id');
    }
}
