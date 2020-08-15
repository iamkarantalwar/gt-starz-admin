<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        return $this->model->orderBy('id', 'DESC')->paginate($this->paginate);
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

    public function changePassword(User $user, array $data)
    {
        $user->password = Hash::make($data['new_password']);
        $user->save();
        return $user;
    }

    public function create(array $data)
    {
        $user = User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "username"  => $data['username'],
            "phone_number" => $data['phone_number'],
            "password" => Hash::make($data['password']),
            "address" => $data['address'],
        ]);

        if($user) {
            return $user;
        } else {
            return null;
        }
    }

    public function update(User $user, array $data) : bool
    {
        $update = $user->update($data);
        if($update) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserByEmail(string $email)
    {
        $user = $this->model->where('email', $email)->first();
        if(is_null($user)) {
            return false;
        } else {
            return $user;
        }
    }
}
