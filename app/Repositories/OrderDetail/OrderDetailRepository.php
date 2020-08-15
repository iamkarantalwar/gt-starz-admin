<?php

namespace App\Repositories\OrderDetail;

use App\Models\Order\OrderDetail;

class OrderDetailRepository implements OrderDetailRepositoryInterface
{
    //Private Model
    private $orderDetail;

    public function __construct(OrderDetail $orderDetail)
    {
        $this->orderDetail = $orderDetail;
    }

    public function create(array $data)
    {
        $deatil = $this->orderDetail->create($data);
        return $deatil;
    }
}
