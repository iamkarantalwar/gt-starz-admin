<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator as PaginationPaginator;

class CategoryController {

    //Repository
    protected $categoryRepository, $productService;

    public function __construct(CategoryRepositoryInterface $categoryRepository, ProductService $productService)
    {
        $this->categoryRepository  = $categoryRepository;
        $this->productService = $productService;
    }

    public function getCategories()
    {
        $categories = $this->categoryRepository->getCategoiresWithImage();
        return response()->json($categories, 200);
    }

    public function getProducts(Request $request, Category $category)
    {
        $paginate = $request->paginate ? $request->paginate : config('constant.pagination.mobile');
        $products = $this->productService->getProductByCategory($category->id);
        $resultWithPagination = new PaginationPaginator($products->toArray(), $paginate);
        return response()->json($resultWithPagination, 200);
    }
}
