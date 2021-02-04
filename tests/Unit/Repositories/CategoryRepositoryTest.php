<?php

namespace Tests\Unit\Repositories;

use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $categoryRepo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryRepo = $this->app->make(CategoryRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        unset($this->categoryRepo);
        parent::tearDown();
    }

    public function test_get_model()
    {
        $categoryModel = $this->categoryRepo->getModel();
        $this->assertEquals(Category::class, $categoryModel);
    }

    public function test_get_root_categories()
    {
        $rootCategories = factory(Category::class, 2)->create([
            'parent_id' => null,
        ]);

        factory(Category::class, 1)->create([
            'parent_id' => $rootCategories->first()->id,
        ]);

        $rootCategoriesQueried = $this->categoryRepo->getRootCategories();
        $this->assertEquals($rootCategories->toArray(), $rootCategoriesQueried->toArray());
    }

    public function test_get_child_categories()
    {
        $parentCategory = factory(Category::class, 1)->create([
            'parent_id' => null,
        ]);

        $childCategories = factory(Category::class, 2)->create([
            'parent_id' => $parentCategory->first()->id,
        ]);

        $childCategoriesQueried = $this->categoryRepo->getChildCategories($parentCategory->first()->id);
        $this->assertEquals($childCategories->toArray(), $childCategoriesQueried->toArray());
    }

    public function test_get_parent_category()
    {
        $parentCategory = factory(Category::class, 1)->create([
            'parent_id' => null,
        ]);

        $childCategory = factory(Category::class, 1)->create([
            'parent_id' => $parentCategory->first()->id,
        ]);

        $parentCategoryIdQueried = $this->categoryRepo->getParentCategoryId($childCategory->first()->id);
        $this->assertEquals($parentCategory->first()->id, $parentCategoryIdQueried);
    }
}
