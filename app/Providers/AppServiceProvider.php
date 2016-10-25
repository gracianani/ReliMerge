<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Entities\Heatsource;
use App\Observers\HeatsourceObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Heatsource::observe(HeatsourceObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
