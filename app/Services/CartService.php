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
            array_push($result, $data);
        }
        return $result;
    }

}
