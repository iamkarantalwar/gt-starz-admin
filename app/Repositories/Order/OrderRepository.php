<?php

namespace App\Repositories\Order;

use App\Models\Order\Order;
use App\Services\CartService;

class OrderRepository implements OrderRepositoryInterface
{
    // Private Field On The Repo
    private $order, $cartService;

    public function __construct(Order $order, CartService $cartService)
    {
        $this->order = $order;
        $this->cartService = $cartService;
    }

    public function all()
    {
        return $this->order->orderBy('id', 'DESC')->get();
    }

    public function show($id)
    {
        return $this->order->where('id', $id)->first();
    }

    public function userOrder($type)
    {
        return $this->order->orderBy('id', 'DESC')->where('order_status', $type)->get();
    }

    public function getOrderById($orderId)
    {
        return $this->order->where('id', $orderId)->first();
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
        $order = $this->order->create($data);
        return $order;
    }

    public function getUserOrders($userId)
    {
        return $this->order->where('user_id', $userId)->get();
    }
}
