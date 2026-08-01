<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Debug logging
        Log::info('AdminMiddleware check', [
            'is_authenticated' => Auth::check(),
            'user_role' => $user ? $user->role : 'not_logged_in',
            'path' => $request->path(),
            'is_ajax' => $request->ajax()
        ]);

        if (Auth::check() && $user->role === 'admin' || $user->role === 'sub_admin') {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
    }
}
