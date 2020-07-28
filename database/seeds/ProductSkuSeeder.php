<?php

use App\Models\Product\ProductSku;
use Illuminate\Database\Seeder;

class ProductSkuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create The SKU details
        $sku = ProductSku::create([
            'product_id' => '1',
            'sku' => '1',
            'price' => '500'
        ]);

        $sku = ProductSku::create([
            'product_id' => '1',
            'sku' => '2',
            'price' => '540'
        ]);

        $sku = ProductSku::create([
            'product_id' => '1',
            'sku' => '3',
            'price' => '560'
        ]);

        $sku = ProductSku::create([
            'product_id' => '1',
            'sku' => '3',
            'price' => '580'
        ]);
    }
}
