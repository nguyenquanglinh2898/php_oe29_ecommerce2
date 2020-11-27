<?php
namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function getModel()
    {
        return Comment::class;
    }

    public function getProductComments($product)
    {
        return $product->comments()->where('parent_id', null)->get();
    }

    public function getProductCommentRate($productId)
    {
        return $this->model->where('product_id', $productId)->where('parent_id', null)->avg('rate');
    }
}
