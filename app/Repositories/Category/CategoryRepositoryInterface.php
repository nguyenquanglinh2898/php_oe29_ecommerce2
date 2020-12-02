<?php
namespace App\Repositories\Category;

use App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function getProductFilteredByCategory();

    public function searchCategory($keyword);

    public function getRootCategories();

    public function getChildCategories($parentId);

    public function getParentCategory($id);
}
