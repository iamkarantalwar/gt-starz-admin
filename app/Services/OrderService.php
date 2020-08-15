<?php

namespace App\Services;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;

class OrderService
{
    // Private Fields On Repositories
    private $orderDetailRepository, $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, OrderDetailRepositoryInterface $orderDetailRepository)
    {
        $this->orderDetailRepository = $orderDetailRepository;
        $this->orderRepository = $orderRepository;
    }

    public function createOrder()
    {

    }
}
