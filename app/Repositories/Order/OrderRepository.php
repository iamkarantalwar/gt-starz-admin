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

    public function getOrdersWithPagination()
    {
        return $this->order->paginate(config('constant.pagination.web'));
    }

    public function update($data,Order $order)
    {
        return $order->update($data);
    }

    public function getDriverPendingOrders($driverId)
    {
        return $this->order->where('driver_id', $driverId)->where('order_status', '=', 'DISPATCHED')->orderBy('id', 'DESC');
    }

    public function getDriverCompletedOrders($driverId)
    {
        return $this->order->where('driver_id', $driverId)->where('order_status', '=', 'DELIVERED')->orderBy('id', 'DESC');
    }
}


