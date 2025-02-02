<?php

namespace App\Providers;

use App\Observers\OrderUpdateObserver;
use App\Observers\PolygraphyApprovedUpdateObserver;
use App\Order;
use App\PolygraphyApproved;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderUpdateObserver::class);
        PolygraphyApproved::observe(PolygraphyApprovedUpdateObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Appzcoder\CrudGenerator\CrudGeneratorServiceProvider');
        }
    }
}
