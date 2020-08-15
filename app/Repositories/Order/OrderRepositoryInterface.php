<?php

namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    public function all();
    public function userOrder($type);
    public function updateStatus($order, $status);
    public function createOrder(array $data);
}
