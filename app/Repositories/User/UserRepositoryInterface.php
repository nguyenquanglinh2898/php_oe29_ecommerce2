<?php
namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getUserCommentsOfProduct($user, $productId);

    public function markNotiAsRead($user, $notiId);

    public function getNumberOfUnreadNoti($user);
}
