<?php

namespace App\Repositories\Driver;

use App\Models\Driver;

interface DriverRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function delete(Driver $driver);
    public function update(array $data, Driver $driver);
    public function changeApprovalStatus(Driver $driver, bool $status);
}
