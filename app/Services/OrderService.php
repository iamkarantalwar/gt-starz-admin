<?php

namespace App\Services;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;

class OrderService
{
    // Private Fields On Repositories
    private $orderDetailRepository, $orderRepository, $cartService;

    public function __construct(OrderRepositoryInterface $orderRepository,
                                OrderDetailRepositoryInterface $orderDetailRepository,
                                CartService $cartService)
    {
        $this->orderDetailRepository = $orderDetailRepository;
        $this->orderRepository = $orderRepository;
        $this->cartService = $cartService;
    }

    public function createOrder(array $data)
    {
        $create = $this->orderRepository->createOrder($data);
        if($create) {
             // Shift Items From Cart To The Order
            $cart = $this->cartService->getUserCart($data['userId']);
            foreach ($cart as $cartItem) {
                $product =
                $this->orderDetailRepository->create([

                ]);
            }
        } else {
            return false;
        }
    }
}
