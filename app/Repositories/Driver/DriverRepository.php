<?php

namespace App\Repositories\Driver;

use Hash;
use App\Models\Driver;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\Hash as FacadesHash;

class DriverRepository implements DriverRepositoryInterface
{
    //Model
    protected $model, $paginate;

    public function __construct(Driver $driver)
    {
        $this->paginate = config('constant.pagination.web');
        $this->model = $driver;
    }

    public function all()
    {
        return $this->model->paginate($this->paginate);
    }

    public function changeApprovalStatus(Driver $driver, bool $status)
    {
        $update = $driver->update([
            'approved' => $status,
        ]);

        if($update) {
            return $driver;
        } else {
            return null;
        }
    }

    public function create(array $data)
    {
        $user = $this->model->create([
            "name" => $data['name'],
            "email" => $data['email'],
            "username"  => $data['username'],
            "phone_number" => $data['phone_number'],
            "password" => FacadesHash::make($data['password']),
            "address" => $data['address'],
        ]);

        if($user) {
            return $user;
        } else {
            return null;
        }
    }


    public function update(array $data, Driver $driver)
    {
        if($data['password'] == null)
        {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $update = $driver->update($data);
        if($update) {
            return $driver;
        } else {
            return null;
        }
    }

    public function delete(Driver $driver)
    {
        $delete = $driver->delete();
        if($delete) {
            return $delete;
        } else {
            return null;
        }
    }

    public function getDriverByEmail(string $email)
    {
        $user = $this->model->where('email', $email)->first();
        if(is_null($user)) {
            return false;
        } else {
            return $user;
        }
    }

    public function changePassword(Driver $user, array $data)
    {
        $user->password = Hash::make($data['new_password']);
        $user->save();
        return $user;
    }

}
