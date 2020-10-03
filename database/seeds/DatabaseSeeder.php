<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // $this->call(AdminSeeder::class);

        //Call the option seeder
       // $this->call(OptionSeeder::class);

        // Call The Category Seeder
        $this->call(CategoryTableSeeder::class);

        //Call all products seeder
        $this->call(ProductSeeder::class);
        // $this->call(ProductSkuSeeder::class);
        // $this->call(ProductOptionSeeder::class);
        // $this->call(ProductSkuValueSeeder::class);
        // $this->call(ProductOptionValueSeeder::class);
    }
}
