<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BuyerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if (auth()->check() && auth()->user()->isBuyer()) {
            if (!auth()->user()->status) {
                abort(403, 'Your buyer profile account is suspended or pending approval.');
            }
            return $next($request);
        }
        abort(403, 'Unauthorized access.');

       
    }
}
