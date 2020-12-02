<?php
namespace App\Repositories\Image;

use App\Models\Image;
use App\Repositories\BaseRepository;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    public function getModel()
    {
        return Image::class;
    }

    public function bulkDeleteImages($imageIds)
    {
        return $this->model->whereIn('id', $imageIds)->forceDelete();
    }
}
