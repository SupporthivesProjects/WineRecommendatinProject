<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

/**
 * Enforces a fixed persistent-login window that starts at the original login
 * and is never extended by activity. The expiry timestamp is kept in the
 * session and in an encrypted cookie, so it survives the session being
 * restored from the remember-me cookie after inactivity or a browser restart.
 */
class EnforceLoginExpiry
{
    public const SESSION_KEY = 'login_expires_at';

    public const COOKIE_NAME = 'login_expires_at';

    /**
     * Start a new login window. Call this right after a successful login.
     */
    public static function start(Request $request): int
    {
        $minutes = (int) config('auth.guards.web.remember');
        $expiresAt = now()->addMinutes($minutes)->getTimestamp();

        $request->session()->put(self::SESSION_KEY, $expiresAt);
        Cookie::queue(self::COOKIE_NAME, (string) $expiresAt, $minutes);

        return $expiresAt;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = Auth::guard('web');

        if (! $guard->check()) {
            if ($request->hasCookie(self::COOKIE_NAME)) {
                Cookie::expire(self::COOKIE_NAME);
            }

            return $next($request);
        }

        $expiresAt = (int) ($request->session()->get(self::SESSION_KEY) ?: $request->cookie(self::COOKIE_NAME));

        if (! $expiresAt && ! $guard->viaRemember()) {
            // Session started before this check existed: begin the window now.
            $expiresAt = self::start($request);
        }

        if (! $expiresAt || now()->getTimestamp() >= $expiresAt) {
            // Expired, or a remember-me cookie without a known login time.
            $guard->logoutCurrentDevice();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Cookie::expire(self::COOKIE_NAME);

            return $next($request);
        }

        $request->session()->put(self::SESSION_KEY, $expiresAt);

        return $next($request);
    }
}
