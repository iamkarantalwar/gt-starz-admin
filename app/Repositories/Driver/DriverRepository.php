<?php

namespace App\Repositories\Driver;

use App\Models\Driver;

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
        $driver = $this->model->create($data);
        if($driver) {
            return $driver;
        } else {
            return null;
        }
    }

    public function update(array $data, Driver $driver)
    {
        if($data['password'] == null)
        {
            unset($data['password']);
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
}
