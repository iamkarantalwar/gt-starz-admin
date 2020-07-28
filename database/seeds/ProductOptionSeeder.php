<?php


use Illuminate\Database\Seeder;
use App\Models\Product\ProductOption;

class ProductOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Relationship Of Product and Options
        $relation = ProductOption::create([
            'product_id' => '1',
            'option_id' => '1'
        ]);

        $relation = ProductOption::create([
            'product_id' => '1',
            'option_id' => '2'
        ]);
    }
}
