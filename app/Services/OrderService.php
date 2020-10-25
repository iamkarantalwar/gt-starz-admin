<?php

namespace App\Services;

use App\Models\Product\ProductSku;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderDetail\OrderDetailRepository;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;

class OrderService
{
    // Private Fields On Repositories
    private $orderDetailRepository, $orderRepository, $cartService, $productService;

    public function __construct(OrderRepository $orderRepository,
                                OrderDetailRepository $orderDetailRepository,
                                CartService $cartService,
                                ProductService $productService)
    {
        $this->orderDetailRepository = $orderDetailRepository;
        $this->orderRepository = $orderRepository;
        $this->cartService = $cartService;
        $this->productService = $productService;
    }

    public function createOrder(array $data)
    {
        $create = $this->orderRepository->createOrder($data);
        if($create) {
             // Shift Items From Cart To The Order
            $cart = $this->cartService->getUserCart($data['user_id']);

            if($cart->count() == 0) {
                $create->delete();
                return false;
            }

            foreach ($cart as $cartItem) {
                $product = $this->productService->getProductByProductIdAndSkuId($cartItem['product_id'], $cartItem['sku_id']);
                $this->orderDetailRepository->create([
                    'product_id' => $product['id'],
                    'sku_id' => $cartItem['sku_id'],
                    'order_id' => $create->id,
                    'product_name' => $product['name'],
                    'cost' => $product['sku']['price'],
                    'discount' => $product['sku']['discount'],
                    'variation_type' => "OPTION",
                    'variation_value' => "VALUE",
                    'total' => floatval(intval($cartItem['quantity']) * $product['sku']['price']) - floatval(intval($cartItem['quantity']) * $product['sku']['discount']),
                    'quantity' => $cartItem['quantity']
                ]);

                $cartItem->delete();
            }

            return true;

        } else {
            return false;
        }
    }

    public function getUserOrders($userId)
    {
        $userOrders = $this->orderRepository->getUserOrders($userId);
        $productSku = new ProductSku();
        return $userOrders->map(function($order) use($productSku){
            $sku = $productSku->where('id', $order->sku_id)->first();
            $order->image = $sku == null ? "" : getImageUrl($sku);
            $order->quantity =  $order->orderProducts->sum('quantity');
            $order->total = $order->orderProducts->sum('total');
            return $order;
        });
    }

    public function getUserOrder($orderId)
    {
        $order = $this->orderRepository->getOrderById($orderId);
        $order->quantity =  $order->orderProducts->sum('quantity');
        $order->total = $order->orderProducts->sum('total');
        return $order;
    }

    public function getOrderDetails($orderId)
    {
        return $this->orderRepository->show($orderId)->orderProducts;
    }

    public function getAllOrdersWithPagination()
    {
        return $this->orderRepository->getOrdersWithPagination();
    }

    public function update($data, $order)
    {
        return $this->orderRepository->update($data, $order);
    }

    public function getDriverPendingOrders($driverId)
    {
        return $this->orderRepository->getDriverPendingOrders($driverId);
    }

    public function getDriverCompletedOrders($driverId)
    {
        return $this->orderRepository->getDriverCompletedOrders($driverId);
    }

    public function getDriverDispacthedOrders($driverId)
    {
        return $this->orderRepository->getDriverCompletedOrders($driverId);
    }
}
