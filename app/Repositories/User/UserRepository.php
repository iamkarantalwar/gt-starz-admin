<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    //Model
    protected $model, $paginate;

    public function __construct(User $user)
    {
        $this->paginate = config('constant.pagination.web');
        $this->model = $user;
    }

    public function all()
    {
        return $this->model->paginate($this->paginate);
    }

    public function changeApprovalStatus(User $user, bool $status)
    {
        $update = $user->update([
            'approved' => $status,
        ]);

        if($update) {
            return $user;
        } else {
            return null;
        }
    }
}
