<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   
     public function handle($request, Closure $next)
     {
         if (auth()->check() && auth()->user()->role === 'store_manager') {
             return $next($request);
         }
     
         return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
     }



}
