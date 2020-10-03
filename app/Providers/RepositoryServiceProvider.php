<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //Registring Category Service Provider
        $this->app->bind(
            'App\Repositories\Category\CategoryRepositoryInterface',
            'App\Repositories\Category\CategoryRepository');

        //Registring Banner Repository
        $this->app->bind(
            'App\Repositories\Banner\BannerRepositoryInterface',
            'App\Repositories\Banner\BannerRepository');

        //Registing The User Service Repository
        $this->app->bind(
            'App\Repositories\User\UserRepositoryInterface',
            'App\Repositories\User\UserRepository');

        //Registing The Driver Service Repository
        $this->app->bind(
            'App\Repositories\Driver\DriverRepositoryInterface',
            'App\Repositories\Driver\DriverRepository');

        //Registing The Driver Service Repository
        $this->app->bind(
            'App\Repositories\Driver\OrderRepositoryInterface',
            'App\Repositories\Driver\OrderRepository');
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
