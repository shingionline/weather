<?php

namespace App\Providers;

use App\Models\User;
use Laravel\Pulse\Facades\Pulse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
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
        if (env('APP_ENV') == 'production') {
            URL::forceScheme('https');
        }

        Gate::define('viewPulse', function (User $user) {
            return $user->account === 'Admin';
        });

    }
}
