<?php

namespace App\Repositories\OrderDetail;

use App\Models\Order\OrderProduct;

class OrderDetailRepository implements OrderDetailRepositoryInterface
{
    //Private Model
    private $orderDetail;

    public function __construct(OrderProduct $orderDetail)
    {
        $this->orderDetail = $orderDetail;
    }

    public function create(array $data)
    {
        $deatil = $this->orderDetail->create($data);
        return $deatil;
    }

    public function find($id)
    {
        return $this->orderDetail->where('id', $id)->first();
    }
}
