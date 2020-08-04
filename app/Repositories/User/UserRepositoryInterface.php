<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all();
    public function changeApprovalStatus(User $user, bool $status);
    public function changePassword(User $user, array $data);
    public function create(array $data);
    public function update(User $user, array $data) : bool;
    public function getUserByEmail(string $email);
}
