<?php

namespace App\Repositories\Order;

use App\Models\Order\Order;

class OrderRepository implements OrderRepositoryInterface
{
    // Private Field On The Repo
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function all()
    {
        return $this->order->orderBy('id', 'DESC')->get();
    }

    public function userOrder($type)
    {
        return $this->order->orderBy('id', 'DESC')->where('order_status', $type)->get();
    }

    public function updateStatus($orderId, $status)
    {
        $update = $this->order
                        ->where('id', $orderId)
                        ->first()
                        ->update([
                            'order_status' => $status,
                        ]);
        if($update) {
            return true;
        } else {
            return false;
        }
    }

    public function createOrder(array $data)
    {
        return $this->order->create($data);
    }
}
