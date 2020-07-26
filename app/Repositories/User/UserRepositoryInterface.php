<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all();
    public function changeApprovalStatus(User $user, bool $status);
}
