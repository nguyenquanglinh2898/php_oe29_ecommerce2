<?php
namespace App\Repositories\Category;

use App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    // lấy ra các danh mục gốc
    public function getRootCategories();

    // lấy các danh mục con từ id của một danh mục cha
    public function getChildCategories($parentId);

    // lấy id danh mục cha từ id một danh mục bất kỳ
    public function getParentCategoryId($id);
}
