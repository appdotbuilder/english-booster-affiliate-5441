<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AffiliateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isAffiliate()) {
            abort(403, 'Access denied. Affiliate privileges required.');
        }

        if (!auth()->user()->is_active) {
            abort(403, 'Access denied. Your affiliate account is inactive.');
        }

        return $next($request);
    }
}