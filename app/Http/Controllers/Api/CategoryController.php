<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryController {

    //Repository
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository  = $categoryRepository;
    }

    public function getCategories()
    {
        $categories = $this->categoryRepository->getCategoiresWithImage();
        return response()->json($categories, 200);
    }
}
