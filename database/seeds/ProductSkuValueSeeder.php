<?php

use App\Models\Product\ProductSkuValue;
use Illuminate\Database\Seeder;

class ProductSkuValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create All SKUS relations

        // 1 - PRODUCT COLOR - SIZE
        $skuValues = ProductSkuValue::create([
            'product_id' => '1',
            'product_sku_id' => '1',
            'product_option_id' => '1',
            'product_value_id' => '1',
        ]);

        $skuValues = ProductSkuValue::create([
            'product_id' => '1',
            'product_sku_id' => '1',
            'product_option_id' => '2',
            'product_value_id' => '5',
        ]);

        // 2 - PRODUCT COLOR - SIZE

        $skuValues = ProductSkuValue::create([
            'product_id' => '1',
            'product_sku_id' => '2',
            'product_option_id' => '1',
            'product_value_id' => '2',
        ]);

        $skuValues = ProductSkuValue::create([
            'product_id' => '1',
            'product_sku_id' => '2',
            'product_option_id' => '2',
            'product_value_id' => '6',
        ]);

         // 3 - PRODUCT COLOR - SIZE

        $skuValues = ProductSkuValue::create([
            'product_id' => '1',
            'product_sku_id' => '3',
            'product_option_id' => '1',
            'product_value_id' => '3',
        ]);

        $skuValues = ProductSkuValue::create([
            'product_id' => '1',
            'product_sku_id' => '3',
            'product_option_id' => '2',
            'product_value_id' => '6',
        ]);

         // 4 - PRODUCT COLOR - SIZE

        $skuValues = ProductSkuValue::create([
            'product_id' => '1',
            'product_sku_id' => '4',
            'product_option_id' => '1',
            'product_value_id' => '4',
        ]);

        $skuValues = ProductSkuValue::create([
            'product_id' => '1',
            'product_sku_id' => '4',
            'product_option_id' => '2',
            'product_value_id' => '6',
        ]);




    }
}
