<?php


use App\Models\Category;
use App\Models\Image;
use App\Models\Product\Product;
use App\Models\Product\ProductSku;
use App\Models\Product\ProductSkuValue;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $categories = Category::all();
        foreach ($categories as $category) {
            for($i=0; $i<5; $i++) {
                $product = Product::create([
                    'category_id' => $category->id,
                    'product_name' => $faker->unique()->name(),
                    'description' => $faker->unique()->text()
                ]);
                // Add 20 Size Variation Products
                if($i < 20) {
                    // Add 4 products
                    for($j=0; $j<4; $j++) {
                        $productSku = ProductSku::create([
                            'product_id' => $product->id,
                            'sku' => null,
                            'price' => $faker->randomNumber(4),
                            'discount' => $faker->randomNumber(3),
                        ]);

                        $image = Image::create([
                            'url' => 'app/models/category/2020-08-20-18-24-49uspolo-1.jpg',
                            'imageable_id' => $productSku->id,
                            'imageable_type' =>get_class($productSku)
                        ]);

                        $productSkuValue = ProductSkuValue::create([
                            'product_id' => $product->id,
                            'product_sku_id' => $productSku->id,
                            'product_option_id' => 1,
                            'product_value_id' => $faker->randomLetter
                        ]);

                    }

                // Add 20 Color Variation Products
                } else if($i < 40) {
                     // Add 4 products
                     for($j=0; $j<4; $j++) {
                        $productSku = ProductSku::create([
                            'product_id' => $product->id,
                            'sku' => null,
                            'price' => $faker->randomNumber(4),
                            'discount' => $faker->randomNumber(3),
                        ]);

                        $image = Image::create([
                            'url' => 'app/models/category/2020-08-20-18-24-49uspolo-1.jpg',
                            'imageable_id' => $productSku->id,
                            'imageable_type' =>get_class($productSku)
                        ]);


                        $productSkuValue = ProductSkuValue::create([
                            'product_id' => $product->id,
                            'product_sku_id' => $productSku->id,
                            'product_option_id' => 1,
                            'product_value_id' => $faker->hexColor,
                        ]);

                    }

                // Add 20 Material Variation Products
                } else if($i < 60) {
                     // Add 4 products
                     for($j=0; $j<4; $j++) {
                        $productSku = ProductSku::create([
                            'product_id' => $product->id,
                            'sku' => null,
                            'price' => $faker->randomNumber(4),
                            'discount' => $faker->randomNumber(3),
                        ]);

                        $image = Image::create([
                            'url' => 'app/models/category/2020-08-20-18-24-49uspolo-1.jpg',
                            'imageable_id' => $productSku->id,
                            'imageable_type' =>get_class($productSku)
                        ]);


                        $productSkuValue = ProductSkuValue::create([
                            'product_id' => $product->id,
                            'product_sku_id' => $productSku->id,
                            'product_option_id' => 1,
                            'product_value_id' => $faker->word(),
                        ]);

                    }
                // Add 20 Weight Variation Products
                } else {
                    // Add 4 products
                    for($j=0; $j<4; $j++) {
                        $productSku = ProductSku::create([
                            'product_id' => $product->id,
                            'sku' => null,
                            'price' => $faker->randomNumber(4),
                            'discount' => $faker->randomNumber(3),
                        ]);

                        $image = Image::create([
                            'url' => 'app/models/category/2020-08-20-18-24-49uspolo-1.jpg',
                            'imageable_id' => $productSku->id,
                            'imageable_type' =>get_class($productSku)
                        ]);


                        $productSkuValue = ProductSkuValue::create([
                            'product_id' => $product->id,
                            'product_sku_id' => $productSku->id,
                            'product_option_id' => 1,
                            'product_value_id' => $faker->randomDigit,
                        ]);

                    }
                }

            }
        }
    }
}
