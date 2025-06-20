<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Если запрос пришел через HTTPS, форсируем генерацию HTTPS-ссылок
        if (request()->secure() || config('app.force_https')) {
            URL::forceScheme('https');
        }
    }
}
