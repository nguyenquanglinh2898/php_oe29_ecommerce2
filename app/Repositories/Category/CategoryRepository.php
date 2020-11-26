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

    public function getProductFilteredByCategory()
    {
        return $this->model->join('products', 'categories.id', '=', 'products.category_id')
            ->select('categories.*', DB::raw('COUNT(products.category_id) as sumcat'))
            ->groupBy('category_id')
            ->orderBy('sumcat', 'DESC')
            ->take(config('config.take'))
            ->get();
    }

    public function searchCategory($keyword)
    {
        return $this->model->with('products')
            ->where('name', 'LIKE', "%$keyword%")
            ->take(config('config.take'))
            ->get();
    }

    public function getRootCategories()
    {
        return $this->model->where('parent_id', null)->get();
    }

    public function getChildCategories($parentId)
    {
        return $this->model->where('parent_id', $parentId)->get();
    }

    public function getParentCategory($id)
    {
        return $this->model->where('id', $id)->first();
    }
}
