<?php

namespace App\Http\Middleware;

use App\Services\SessionCart;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Copies the saved cart (session_carts table) into session('cart') at the start of
 * every logged-in request, so pages and controllers that read the session always
 * see the latest cart, even if another request saved an older copy of the session.
 */
class SyncSessionCart
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasSession() && $request->user()) {
            $items = SessionCart::stored();
            if ($items !== null) {
                $request->session()->put('cart', $items);
            }
        }

        return $next($request);
    }
}
