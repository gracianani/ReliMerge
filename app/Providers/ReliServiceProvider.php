<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\HeatsourceService;
use App\Services\TotalNetService;
use App\Services\StationService;
use App\Services\DashboardService;
use App\Services\GeneralService;

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

        $this->app->bind('stationService', function ($app) {
            return new StationService();
        });

        $this->app->bind('dashboardService', function ($app) {
            return new DashboardService();
        });

        $this->app->bind('generalService', function ($app) {
            return new GeneralService();
        });
    }
}
