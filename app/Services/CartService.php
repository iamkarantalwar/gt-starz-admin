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

    public function getCartProducts(array $cart)
    {
        $result = [];
        foreach($cart as $item) {
            $data = $this->productService->getProductWithVariation($item['productId'], $item['skuId']);
            $data['price'] = intval($item['quantity']) * $data['skus']['price'];
            array_push($result, $data);
        }
        return $result;
    }

    public function updateCart(array $cart, $userId)
    {
        $userCart = $this->cart->where('user_id', $userId)->get();
        // Remove the Existing Cart
        foreach($userCart as $item) {
            $item->delete();
        }

        // Add Items Into The Cart
        foreach($cart as $item) {
            $cart = $this->cart->create([
                'product_id' => $item['productId'],
                'sku_id' => $item['skuId'],
                'quantity' => $item['quantity'],
                'user_id' => $userId
            ]);
        }
    }

    public function removeItemFromCart($cartItem, $user)
    {
        $item = $this->cartRepository->where('id', $cartItem->id)->first()->delete();
    }

    public function updateCartItem($cart, $item)
    {
        $update = $cart->update([
            'product_id' => $item['productId'],
            'sku_id' => $item['skuId'],
            'quantity' => $item['quantity'],
        ]);

        if($update) {
            return true;
        } else {
            return false;
        }
    }
}
