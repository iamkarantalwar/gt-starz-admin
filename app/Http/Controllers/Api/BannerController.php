<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Banner\BannerRepositoryInterface;

class BannerController {

    //Repository
    protected $bannerRepository;

    public function __construct(BannerRepositoryInterface $bannerRepository)
    {
        $this->bannerRepository  = $bannerRepository;
    }

    public function getBannerImages()
    {
        $banners = $this->bannerRepository->getBannerImages();
        return response()->json($banners, 200);
    }
}
