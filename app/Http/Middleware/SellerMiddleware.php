<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if logged in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // 2. Check if user is a seller
        if (!$user->isSeller()) {
            abort(403, 'Unauthorized access. Seller only.');
        }

        // 3. Check if account is active
        if (!$user->status) {
            abort(403, 'Your account is deactivated.');
        }

        // 4. Check if seller has profile
        $sellerDetail = $user->sellerDetail;

        if (!$sellerDetail) {
            return redirect()->route('seller.profile.index')
                ->with('warning', 'Please complete your store profile.');
        }

        // 5. Check suspension status
        if ($sellerDetail->isSuspended()) {
            abort(403, 'Your store has been suspended.');
        }

        // 6. Check verification status
        if (!$sellerDetail->is_verified) {
            abort(403, 'Your store is pending admin approval.');
        }

        // All checks passed ✅
        return $next($request);
    }
}