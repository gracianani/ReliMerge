<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\HeatsourceService;
use App\Services\TotalNetService;

class ReliServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('heatsourceService', function ($app) {
            return new HeatsourceService();
        });

        $this->app->bind('totalNetService', function ($app) {
            return new TotalNetService();
        });
    }
}
