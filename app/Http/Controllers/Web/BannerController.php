<?php

namespace App\Http\Controllers\Web;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Requests\Web\BannerRequest;
use App\Repositories\Banner\BannerRepositoryInterface;

class BannerController extends Controller
{
    //Make Reposiotry Protected
    protected $bannerRepository;

    public function __construct(BannerRepositoryInterface $bannerRepositoryInterface)
    {
        $this->bannerRepository = $bannerRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = $this->bannerRepository->all();
        return view('banner.index')->with(['banners' => $banners, 'banner' => null]);
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
            return redirect()->back()->with('danger', 'Banner creation error. Try again later.');
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
        if($banner) {
            return view('banner.index')->with(['banners' => $banners, 'banner' => $banner]);
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
            return redirect()->back()->with('danger', 'Something went wrong. Try again later.');
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
            return redirect()->back()->with('danger', 'Something went wrong.Try again later.');
        }
    }
}
