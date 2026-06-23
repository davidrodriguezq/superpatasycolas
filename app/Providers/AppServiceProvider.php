<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        
        Paginator::useBootstrapFive();

        try {
            $settings = Setting::pluck('value', 'key')->toArray();
            view()->share('settings', $settings);
        } catch (\Exception $e) {
            view()->share('settings', []);
        }
    }
}
