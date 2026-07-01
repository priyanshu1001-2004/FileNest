<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isSeller()) {
            if (!auth()->user()->status) {
                abort(403, 'Your seller profile account is suspended or pending approval.');
            }
            return $next($request);
        }
        abort(403, 'Unauthorized access to Seller Management Portal.');
    }
}
