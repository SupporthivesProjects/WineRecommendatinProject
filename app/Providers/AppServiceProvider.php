<?php

namespace App\Providers;

use App\Services\ProductImageService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;


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
        // View composer for pending contact requests
        View::composer('*', function ($view) {
            $pendingRequests = 0;

            if (Auth::check() && Auth::user()->role !== 'user') {
                $managerId = Auth::id();
                $pendingRequests = Store::where('manager_id', $managerId)
                    ->where('contact_status', 'pending')
                    ->whereNotNull('new_contact_number')
                    ->count();
            }

            $view->with('pendingRequests', $pendingRequests);
        });
    }
}
