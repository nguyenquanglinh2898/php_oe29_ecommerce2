<?php

namespace Tests\Unit;

use App\Models\Image;
use Tests\TestCase;

class ImageTest extends TestCase
{
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Image();
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

    public function test_contain_dates_properties()
    {
        $this->assertContains('deleted_at', $this->model->getDates());
    }

    public function test_morph_to_relation()
    {
        $this->assertMorphTo($this->model, 'imageable');
    }
}
