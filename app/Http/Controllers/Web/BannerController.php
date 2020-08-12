<?php

namespace App\Http\Controllers\Web;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Requests\Web\BannerRequest;
use App\Repositories\Banner\BannerRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;

class BannerController extends Controller
{
    //Make Reposiotry Protected
    protected $bannerRepository, $categoryRepository;

    public function __construct(BannerRepositoryInterface $bannerRepositoryInterface, CategoryRepositoryInterface $categoryRepository)
    {
        $this->bannerRepository = $bannerRepositoryInterface;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = $this->bannerRepository->all();
        $categories = $this->categoryRepository->getCategoiresWithoutPagination();
        return view('banner.index')->with([
            'banners' => $banners,
            'banner' => null,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {
        $store = $this->bannerRepository->create($request->all());
        if($store) {
            return redirect()->route('banners.index')->with('success', 'Banner Created Successfully');
        } else {
            return redirect()->back()->with('error', 'Banner creation error. Try again later.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $category)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        $banners = $this->bannerRepository->all();
        $banner = $this->bannerRepository->getBanner($banner);
        $categories = $this->categoryRepository->getCategoiresWithoutPagination();

        if($banner) {
            return view('banner.index')->with([
                'banners' => $banners,
                'banner' => $banner,
                'categories' => $categories
            ]);
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
    public function update(BannerRequest $request, Banner $banner)
    {
        $banner = $this->bannerRepository->getBanner($banner);
        $update = $this->bannerRepository->update($request->all(), $banner);
        if($update) {
            return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong. Try again later.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner = $this->bannerRepository->getBanner($banner);
        $delete = $this->bannerRepository->delete($banner);
        if($delete) {
            return redirect()->back()->with('success', 'Banner deleted successfully.');
        } else{
            return redirect()->back()->with('error', 'Something went wrong.Try again later.');
        }
    }
}
