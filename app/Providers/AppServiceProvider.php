<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
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
        Vite::prefetch(concurrency: 3);

        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('site_settings')) {
                    $view->with('settings', SiteSetting::getAllSettings());
                }
            } catch (\Throwable $e) {
                // Graceful fallback during migration or setup
            }
        });
    }
}
