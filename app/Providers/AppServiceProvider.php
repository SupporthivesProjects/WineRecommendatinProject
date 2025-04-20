<?php

namespace App\Providers;

use App\Services\ProductImageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind ProductImageService to the service container
        $this->app->bind(ProductImageService::class, function ($app) {
            return new ProductImageService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
