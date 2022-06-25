<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repo\Cache\{CacheInterface, Cache};
class VillaCacheProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(CacheInterface::class, Cache::class);
    }
}
