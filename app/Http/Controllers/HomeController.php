<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Banner\BannerRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Driver\DriverRepositoryInterface;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // Protected Repositories
    protected $driverRepository, $userRepository, $bannerRepository, $categoryRepository;

    public function __construct(DriverRepositoryInterface $driverRepository, UserRepositoryInterface $userRepository,
                                BannerRepositoryInterface $bannerRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->bannerRepository = $bannerRepository;
        $this->driverRepository = $driverRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome')->with([
            'users' => $this->userRepository->all()->slice(0, 5),
            'drivers' => $this->driverRepository->all(),
            'banners' => $this->bannerRepository->all(),
            'categories' => $this->categoryRepository->all(),
        ]);
    }
}
