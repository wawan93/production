<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('approve-maket', function($user) {
            if ($user->role !== 'admin') {
                return false;
            }

            if (strpos($user->extra_class, 'c_maket_approve') === false) {
                return false;
            }

            return true;
        });

        Gate::define('update-order', function($user) {
            if ($user->role !== 'admin') {
                return false;
            }

            if (strpos($user->extra_class, 'c_orders_manager') === false) {
                return false;
            }

            return true;
        });

        Gate::define('update-warehouse', function($user) {
            if ($user->role !== 'admin') {
                return false;
            }

            if (strpos($user->extra_class, 'c_warehouse_manager') === false) {
                return false;
            }

            return true;
        });
    }
}
