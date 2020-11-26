<?php
namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getUserCommentsOfProduct($user, $productId)
    {
        return $user->comments()->where('product_id', $productId)->where('parent_id', null)->first();
    }

    public function markNotiAsRead($user, $notiId)
    {
        return $user->unreadNotifications->where('id', $notiId)->markAsRead();
    }

    public function getNumberOfUnreadNoti($user)
    {
        return $user->unreadNotifications()->count();
    }
}
