<?php

use App\Models\Product\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //All Options
        $option = Option::create([
            'option_name' => 'SIZE',
            'slug' => 'size',
        ]);

        $option = Option::create([
            'option_name' => 'COLOR',
            'slug' => 'color',
        ]);

        $option = Option::create([
            'option_name' => 'MATERIAL',
            'slug' => 'material',
        ]);

        $option = Option::create([
            'option_name' => 'WEIGHT',
            'slug' => 'material',
        ]);

    }
}
