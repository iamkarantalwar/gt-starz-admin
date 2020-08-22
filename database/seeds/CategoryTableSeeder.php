<?php

use App\Models\Category;
use App\Models\Image;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    protected $categoryRepository;

    public function __construct(Category $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for($i=0; $i<=50; $i++) {
            $category = $this->categoryRepository->create([
                'category_name' => $faker->name(),
            ]);

            $image = Image::create([
                'url' => 'app/models/category/2020-08-20-18-24-49uspolo-1.jpg',
                'imageable_id' => $category->id,
                'imageable_type' =>get_class($category)
            ]);
        }
    }
}
