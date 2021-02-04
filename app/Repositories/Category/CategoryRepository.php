<?php
namespace App\Repositories\Category;

use DB;
use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }

    public function getRootCategories()
    {
        return $this->model->where('parent_id', null)->get();
    }

    public function getChildCategories($parentId)
    {
        return $this->model->where('parent_id', $parentId)->get();
    }

    public function getParentCategoryId($childCategoryId)
    {
        return $this->model->where('id', $childCategoryId)->first()->parent_id;
    }
}
