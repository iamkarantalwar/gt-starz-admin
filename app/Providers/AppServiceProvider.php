<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $notifications = Notification::orderBy('id', 'DESC')->get();
            view()->share('notifications', $notifications);
        } catch (\Throwable $th) {
            //throw $th;
        }

    }
}
