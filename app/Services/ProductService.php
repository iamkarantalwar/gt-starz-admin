<?php

namespace App\Services;

use App\Models\Image;
use Storage;
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

    public function update(array $data, Product $product)
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

        //Update Product Information
        $product_update = $product->update([
            'product_name' => $data['product_name'],
            'description' => $data['description'],
            'category_id' => $data['category_id'],
         ]);
        //Compare the new variation and old variation id

        $old_variation_id = $product->skus[0]->productValues[0]->product_option_id;
        $new_variation_id = explode("variant-", $variants[0])[1];

        $option_id = $old_variation_id == $new_variation_id ? $old_variation_id : $new_variation_id;

        // Make An array that skus are updated
        $skusUpdated = [];
        $sku_old_ids = $data['ids'];
        $newImageIndex = 0;
        // If Product is added then Add Skus
        if($product_update) {
            //Iterate over the price,variation and all
            for($i=0; $i<count($data['price']); $i++)
            {
                $price = $data['price'][$i];
                $discount = $data['discount'][$i];
                $value = $data[$variants[0]][$i];

                // Check if SKU id is exist then update else create a new sku
                if(isset($sku_old_ids[$i])) {
                    // Update a sku
                    $skuId = $sku_old_ids[$i];
                    $productSku =  $this->productSku
                                        ->where('product_id', $product->id)
                                        ->where('id', $skuId)
                                        ->first();

                    $productSkuUpdate = $this->productSku
                                            ->where('product_id', $product->id)
                                            ->where('id', $skuId)
                                            ->update(
                                        [
                                            'price' => $price,
                                            'discount' => $discount
                    ]);
                    // Append Into The Skus Updated
                    array_push($skusUpdated, $skuId);
                    // If Image is coming then update the image
                    if(isset($data['image-'.$skuId])) {
                        $image = updateImage($data['image-'.$skuId], $productSku);
                    }

                    $productSku = $this->productSkuValue
                                       ->where('product_id', $product->id)
                                       ->where('product_sku_id', $skuId)
                                       ->update([
                                            'product_option_id' => $option_id,
                                            'product_value_id' => $value
                                       ]);

                } else {
                    // Create a sku
                    $productSku = $this->productSku->create([
                        'price' => $price,
                        'product_id' => $product->id,
                        'discount' => $discount
                    ]);

                    // If sku is added then add images
                    $image = addImage($data['image'][$newImageIndex], $productSku);
                    $newImageIndex++;
                    //If image is added
                    if($image) {
                        //Store Variation with the sku
                        $productSkuValue = $this->productSkuValue->create([
                            'product_id' => $product->id,
                            'product_sku_id' => $productSku->id,
                            'product_option_id' => $option_id,
                            'product_value_id' => $value
                        ]);
                    } else {
                        // Delete the sku
                        $productSku->delete();
                        return [
                            "status" => false,
                            "message" => "Variation add failed.",
                        ];
                    }
                }
                $sku_old_ids = $product->skus->pluck('id');
                // If Old SKU is Not Coming After updation then delete the variation
                foreach ($sku_old_ids as $skuOldId) {
                    if(!in_array($skuOldId, $skusUpdated)) {
                        $sku = $this->productSku
                        ->where('product_id', $product->id)
                        ->where('id', $skuOldId);

                        deleteImage($sku);

                        $productSku = $this->productSku
                                            ->where('product_id', $product->id)
                                            ->where('id', $skuOldId)
                                            ->delete();

                        $productSku = $this->productSkuValue
                                            ->where('product_id', $product->id)
                                            ->where('product_sku_id', $skuOldId)
                                            ->delete();
                    }
                }
            }
            return [
                "status" => true,
                "message" => "Product Updates Successfully.",
            ];
        } else {
            return [
                "status" => false,
                "message" => "Product Updation Failed.Try gain Later.",
            ];
        }

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
        ])->orderBy('id', 'DESC');
    }

    public function getAllProducts()
    {
        $products =  $this->all()->get();
        return $products;
    }

    public function getProductByProductIdAndSkuId(int $productId, int $skuId)
    {
        $product =  $this->all()->where('id', $productId)->first();

        $sku = $product->skus->where('id', $skuId)->first();

        $variations_result =  [];
        foreach($sku->productValues as $variation) {
            $option = $variation->productOption != null ? $variation->productOption->option_name : null;
            $variations_result[$option] = $variation->product_value_id;
        }

        $product = [
            'id' => $product->id,
            'name' => $product->product_name,
            'description' => $product->description,
            'sku' => [
                'id' => $sku->id,
                'sku' => $sku->sku,
                'price' => $sku->price,
                'discount' => $sku->discount,
                'image' => Storage::disk('s3')->url($sku->image->url),
                'options' => $variations_result
            ]
        ];
        return $product;
    }

    public function getProduct(int $id)
    {
        $product =  $this->all()->where('id', $id)->first();
        $product = [
            'id' => $product->id,
            'name' => $product->product_name,
            'description' => $product->description,
            'skus' => $product->skus->map(function($sku) {

            $variations_result =  [];
            foreach($sku->productValues as $variation) {
                $option = $variation->productOption != null ? $variation->productOption->option_name : null;
                $variations_result[$option] = $variation->product_value_id;
            }

                $sku = [
                    'id' => $sku->id,
                    'sku' => $sku->sku,
                    'price' => $sku->price,
                    'discount' => $sku->discount,
                    'image' => $sku->images->map(function($image) {
                        return Storage::disk(env('STORAGE_ENGINE'))->url($image->url);
                    }),
                    'options' => $variations_result
                ];

                return $sku;

            }),
        ];
        return $product;
    }

    public function getProductByCategory($id)
    {
        $products =  $this->all()->where('category_id', $id)->get();
       // return $products;
        $products = $products->map(function($product) {
                $product = [
                    'id' => $product->id,
                    'name' => $product->product_name,
                    'description' => $product->description,
                    'skus' => $product->skus->map(function($sku) {

                    $variations_result =  [];
                    foreach($sku->productValues as $variation) {
                        $option = $variation->productOption != null ? $variation->productOption->option_name : null;
                        $variations_result[$option] = $variation->product_value_id;
                    }

                        $sku = [
                            'sku' => $sku->sku,
                            'price' => $sku->price,
                            'discount' => $sku->discount,
                            'image' => $sku->image != null ? getImageUrl($sku) : null,
                            'options' => $variations_result
                        ];

                        return $sku;

                    })->unique('options.COLOR')->values(),
                ];
                return $product;
        });
        return $products;
    }

    public function getProductForEdit(Product $product)
    {
        $product =  $this->all()->where('id', $product->id)->first();
        return $product;
    }

    public function filterProducts($search)
    {
        return $this->product->where('product_name', 'like', '%'.$search.'%')->orderBy('id', 'DESC');
    }

    public function getProductWithVariation($productId, $skuId) {
        $productWithSkuAndImage = $this->getProduct($productId);
        $productWithSkuAndImage['skus'] = $productWithSkuAndImage['skus']->where('id', $skuId)->values()->collapse();
        return $productWithSkuAndImage;
    }

    public function deleteProduct($product) {
        try {

            $productSkuValues = $this->productSkuValue->where('product_id', $product->id);
            foreach($productSkuValues as $productSkuValue) {
                $productSkuValue->delete();
            }

            $productSkus = $this->productSku->where('product_id', $product->id);
            foreach($productSkus as $productSku) {
                deleteImage($productSku);
                $productSku->delete();
            }


            $product = $this->product->where('id', $product->id)->delete();
            return true;

        } catch(\Exception $e) {
            dd($e);
            return false;
        }

    }

}
