<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repo\ImageProcess\{ImageProcessClass, ImageProcessInterface};

class ImageProcessProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ImageProcessInterface::class, ImageProcessClass::class);
    }
}
