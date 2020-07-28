<?php

use App\Models\Product\ProductOptionValue;
use Illuminate\Database\Seeder;

class ProductOptionValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // All values of the product and its option
        $productOptionValue = ProductOptionValue::create([
            'product_id' => '1',
            'option_id' => '1',
            'value_name' => 'X'
        ]);

        $productOptionValue = ProductOptionValue::create([
            'product_id' => '1',
            'option_id' => '1',
            'value_name' => 'XL'
        ]);

        $productOptionValue = ProductOptionValue::create([
            'product_id' => '1',
            'option_id' => '1',
            'value_name' => 'S'
        ]);

        $productOptionValue = ProductOptionValue::create([
            'product_id' => '1',
            'option_id' => '1',
            'value_name' => 'L'
        ]);

        $productOptionValue = ProductOptionValue::create([
            'product_id' => '1',
            'option_id' => '2',
            'value_name' => 'Orange'
        ]);

        $productOptionValue = ProductOptionValue::create([
            'product_id' => '1',
            'option_id' => '2',
            'value_name' => 'Green'
        ]);
    }
}
