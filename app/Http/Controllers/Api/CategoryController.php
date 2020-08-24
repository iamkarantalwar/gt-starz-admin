<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $resultWithPagination = $this->paginate($products, $paginate, $request->page);
        return response()->json($resultWithPagination, 200);
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage)->values(), $items->count(), $perPage, $page, $options);
    }
}
