<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production (behind Cloudflare/Nginx proxy)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Gate::define('viewScalar', function(?User $user){
            return $user && in_array($user->email, [
                "adminli@gmail.com"
            ]);
        });
    }
}
