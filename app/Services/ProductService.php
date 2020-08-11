<?php

namespace App\Services;

use App\Models\Product\Option;
use App\Models\Product\Product;
use App\Models\Product\ProductSku;
use App\Models\Product\ProductSkuValue;

class ProductService
{
    // Private Fields On The Service
    private $productSku, $product, $productSkuValue;

    public function __construct(Product $product, Option $option, ProductSku $productSku, ProductSkuValue $productSkuValue)
    {
        $this->productSku = $productSku;
        $this->product = $product;
        $this->productSkuValue = $productSkuValue;
    }

    public function addProduct(array $data)
    {
        //Find All The Variations
        $variants = [];
        foreach(array_keys($data) as $key)
        {
            $check = explode('variant-', $key);
            if(count($check) == 2)
            {
                array_push($variants, $key);
            }
        }
        //If Variants are not available don't run any query
        if(count($variants) == 0) {
            return [
                "status" => false,
                "message" => "Please Enter At Least One Variation",
            ];
        }
        //Add Product Information
        $product = $this->product->create([
            'product_name' => $data['product_name'],
            'description' => $data['description'],
            'category_id' => $data['category_id'],
        ]);

        // If Product is added then Add Skus
        if($product) {
            //Iterate over the price,variation and all
            for($i=0; $i<count($data['price']); $i++)
            {
                // Create a sku
                $price = $data['price'][$i];
                $discount = $data['discount'][$i];

                $productSku = $this->productSku->create([
                    'price' => $price,
                    'product_id' => $product->id,
                    'discount' => $discount
                ]);

                // If sku is added then add images
                $image = addImage($data['image'][$i], $productSku);
                //If image is added
                if($image) {
                    //Iterate Over Vairation and store all the type and values
                    for($k=0; $k<count($variants); $k++)
                    {
                        $variant =  $variants[$k];
                        $option_id = explode('variant-', $variant)[1];
                        $value = $data[$variant][$i];

                            // //Store Each Variation with the sku
                        $productSkuValue = $this->productSkuValue->create([
                            'product_id' => $product->id,
                            'product_sku_id' => $productSku->id,
                            'product_option_id' => $option_id,
                            'product_value_id' => $value
                        ]);
                    }
                } else {
                    // Delete the sku
                    $productSku->delete();
                    return [
                        "status" => false,
                        "message" => "Variation add failed.",
                    ];
                }

            }
            return [
                "status" => true,
                "message" => "Product Added Successfully.",
            ];
        } else {
            return [
                "status" => false,
                "message" => "Product Addition Failed.Try gain Later.",
            ];
        }
    }

    public function all()
    {
        return $this->product
        ->with([
            'skus',
            'skus.images',
            'skus.productValues' ,
            'skus.productValues.productOption',
        ]);
    }

    public function getAllProducts()
    {
        $products =  $this->all()->get();
        return $products;
    }

    public function getProduct(int $id)
    {
        $product =  $this->all()->where('id', $id)->first();
        return $product;
    }

    public function getProductByCategory($id)
    {
        $products =  $this->all()->where('category_id', $id)->get();
       // return $products;
        $products = $products->map(function($product) {
                $product = [
                    'name' => $product->product_name,
                    'description' => $product->description,
                    'skus' => $product->skus->map(function($sku) {

                                $variations = $sku->productValues->map(function($variation) {
                                    $variation = [
                                        'option' => $variation->productOption != null ? $variation->productOption->option_name : null,
                                        'value' => $variation->product_value_id
                                    ];
                                    return $variation;
                                });

                                $sku = [
                                    'sku' => $sku->sku,
                                    'price' => $sku->price,
                                    'discount' => $sku->discount,
                                    'image' => $sku->image != null ? getImageUrl($sku) : null,
                                    'variations' => $variations
                                ];
                                return $sku;
                    })
                ];
                return $product;
        });
        return $products;
    }

}
