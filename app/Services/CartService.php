<?php

namespace App\Services;

use App\Models\Cart;

class CartService {
    // Private Fields

    private $cartRepository, $productService;

    public function __construct(Cart $cart, ProductService $productService)
    {
        $this->cartRepository = $cart;
        $this->productService = $productService;
    }

    public function getCartProducts(array $cart) : array
    {
        $result = [];
        foreach($cart as $item) {
            $data = $this->productService->getProductByProductIdAndSkuId($item['productId'], $item['skuId']);
            $item['quantity'] = isset($item['quantity']) ? $item['quantity'] : 1;
            $data['price'] = intval($item['quantity']) * $data['sku']['price'];
            $data['cartId'] = $item['id'];
            $data['quantity'] = $item['quantity'];
            array_push($result, $data);
        }
        return $result;
    }

    public function addItemsToCartAfterLogin(array $carts, int $userId) {
        foreach ($carts as $cart) {
            $cart['user_id'] = $userId;
        }
        $cartItems = $this->cartRepository->insert($carts);
        if($cartItems) {
            return true;
        } else {
            return false;
        }
    }

    public function mergeCart($oldCart)
    {

    }

    public  function getUserCart($userId)
    {
        return $this->cartRepository->where('user_id', $userId)->get();
    }

    // public function updateCart(array $cart, $userId)
    // {
    //     $userCart = $this->cart->where('user_id', $userId)->get();
    //     // Remove the Existing Cart
    //     foreach($userCart as $item) {
    //         $item->delete();
    //     }

    //     // Add Items Into The Cart
    //     foreach($cart as $item) {
    //         $cart = $this->cart->create([
    //             'product_id' => $item['productId'],
    //             'sku_id' => $item['skuId'],
    //             'quantity' => $item['quantity'],
    //             'user_id' => $userId
    //         ]);
    //     }
    // }

    public function removeItemFromCart($cartItem)
    {
        $item = $this->cartRepository->where('id', $cartItem->id)->first()->delete();
        if($item) {
            return true;
        } else{
            return false;
        }
    }

    public function updateCartItem($cart, $item)
    {
        $update = $cart->update([
            'sku_id' => $item['skuId'],
            'quantity' => $item['quantity'],
        ]);

        if($update) {
            return true;
        } else {
            return false;
        }
    }

    public function addToCart($data, $userId)
    {

        $create = $this->cartRepository->create([
            'product_id' => $data['productId'],
            'sku_id' => $data['skuId'],
            'user_id'=> $userId,
            'quantity' => isset($data['quantity']) ? $data['quantity'] : 1,
        ]);

        if($create) {
            return $create;
        } else {
           return false;
        }
    }
}
