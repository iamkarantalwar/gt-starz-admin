<?php

namespace App\Repositories\Category;

use App\Models\Category;

interface CategoryRepositoryInterface {
    public function create(array $data);
    public function all();
    public function filterCategories($search);
    public function getCategory(Category $category);
    public function update(array $data, Category $category);
    public function delete(Category $category);
    public function getCategoiresWithImage();
}
