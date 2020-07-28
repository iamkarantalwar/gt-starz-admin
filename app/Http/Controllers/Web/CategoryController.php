<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Web\CategoryRequest;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    //Make Reposiotry Protected
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->all();
        return view('category.index')->with(['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.add-edit')->with(['category' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //   dd(realpath($request->all()['image']));
        uploadImage($request->all()['image']);
        dd("success");
        $store = $this->categoryRepository->create($request->all());

        if($store) {
            return redirect()->route('categories.index')->with('success', 'Category Created Successfully');
        } else {
            return redirect()->back()->with('danger', 'Category creation error. Try again later.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $category = $this->categoryRepository->getCategory($category);
        if($category) {
            return view('category.add-edit')->with(['category' => $category]);
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category = $this->categoryRepository->getCategory($category);
        $update = $this->categoryRepository->update($request->all(), $category);
        if($update) {
            return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
        } else {
            return redirect()->back()->with('danger', 'Something went wrong. Try again later.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category = $this->categoryRepository->getCategory($category);
        $delete = $this->categoryRepository->delete($category);
        if($delete) {
            return redirect()->back()->with('success', 'Category deleted successfully.');
        } else{
            return redirect()->back()->with('danger', 'Something went wrong.Try again later.');
        }
    }
}
