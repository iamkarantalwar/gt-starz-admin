<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product\Option;
use App\Models\Product\Product;
use App\Repositories\Category\CategoryRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Private fields on this model
    private $product, $option, $productService, $categoryRepository;

    public function __construct(Product $product, Option $option, ProductService $productService, CategoryRepository $categoryRepository)
    {
        $this->option = $option;
        $this->product = $product;
        $this->productService = $productService;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->search) {
            $products = $this->productService->filterProducts($request->search)->paginate(config('constant.pagination.web'));
        } else {
            $products = $this->productService->all()->paginate(config('constant.pagination.web'));
        }

        return view('product.index')->with([
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.add-edit')->with([
            'product' => null,
            'options' => $this->option->all(),
            'categories' => $this->categoryRepository->getCategoiresWithoutPagination(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = $this->productService->addProduct($request->all());
        if($product['status'] == true) {
            return redirect()->back()->with('success', $product['message']);
        } else {
            return redirect()->back()->with('error', $product['message']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product.add-edit')->with([
            'product' => $product,
            'options' => $this->option->all(),
            'categories' => $this->categoryRepository->getCategoiresWithoutPagination(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product = $this->productService->update($request->all(), $product);
        if($product['status'] == true) {
            return redirect()->back()->with('success', $product['message']);
        } else {
            return redirect()->back()->with('error', $product['message']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $delete = $this->productService->deleteProduct($product);
        if($delete) {
            return redirect()->back()->with('success', 'Category deleted successfully.');
        } else{
            return redirect()->back()->with('error', 'Something went wrong. Try again later.');
        }
    }
}
