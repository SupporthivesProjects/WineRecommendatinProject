<?php

namespace App\Http\Middleware;

use App\Models\SiteAnalyticsEvent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Records a page view when a logged-in kiosk user (role "user") opens a page.
 * Only full page loads count: background requests (fetch / AJAX, JSON) and
 * errors or redirects are ignored. Never affects the response.
 */
class TrackPageView
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            $user = $request->user();

            if (
                $user
                && $user->role === 'user'
                && $request->isMethod('GET')
                && !$request->ajax()
                && !$request->expectsJson()
                && $response->getStatusCode() === 200
                && str_contains((string) $response->headers->get('Content-Type'), 'text/html')
                && $request->route()
                && $request->route()->getName()
            ) {
                $route = $request->route();

                // Wine pages: remember which wine (two routes show a wine)
                $productId = match ($route->getName()) {
                    'user.productdetails' => $route->parameter('id'),
                    'products.show' => $route->parameter('product'),
                    default => null,
                };
                if (is_object($productId)) {
                    $productId = $productId->getKey();
                }

                SiteAnalyticsEvent::create([
                    'event' => SiteAnalyticsEvent::PAGE_VIEW,
                    'user_id' => $user->id,
                    'store_id' => $user->store_id,
                    'route_name' => $route->getName(),
                    'path' => mb_substr('/' . ltrim($request->path(), '/'), 0, 255),
                    'product_id' => is_numeric($productId) ? (int) $productId : null,
                ]);
            }
        } catch (\Throwable $e) {
            // Analytics must never break a page
            Log::warning('Page view not recorded: ' . $e->getMessage());
        }

        return $response;
    }
}
