<?php

namespace App\Broadcasting;

use App\Models\User;

class CustomerOrderChannel
{
    public function join(User $user, $supplierId)
    {
        return $user->id == $supplierId;
    }
}
