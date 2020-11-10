<?php

namespace Tests\Unit;

use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Tests\TestCase;

class DistrictTest extends TestCase
{
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new District();
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

    public function test_has_many_wards_relation()
    {
        $this->assertHasMany($this->model, 'wards', Ward::class, 'district_id', 'id');
    }

    public function test_belongs_to_province_relation()
    {
        $this->assertBelongsTo($this->model, 'province', Province::class, 'province_id', 'id');
    }
}
