<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class CommentTest extends TestCase
{
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Comment();
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

    public function test_belongs_to_product_relation()
    {
        $this->assertBelongsTo($this->model, 'product', Product::class, 'product_id', 'id');
    }

    public function test_morph_many_images_relation()
    {
        $this->assertMorphMany($this->model, 'images', Image::class, 'imageable_id', 'imageable_type');
    }

    public function test_has_one_children_relation()
    {
        $this->assertHasOne($this->model, 'children',Comment::class, 'parent_id', 'id');
    }

    public function test_belongs_to_parent_relation()
    {
        $this->assertBelongsTo($this->model, 'parent', Comment::class, 'parent_id', 'id');
    }
}
