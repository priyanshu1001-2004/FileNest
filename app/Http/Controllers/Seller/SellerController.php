<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SellerController extends Controller
{
    public function dashboard()
    {
        try {
            $sellerId = auth()->id();

            // Statistics
            $totalProducts = Product::where('seller_id', $sellerId)->count();
            $pendingProducts = Product::where('seller_id', $sellerId)
                ->where('status', 'pending')->count();
            $publishedProducts = Product::where('seller_id', $sellerId)
                ->where('status', 'published')
                ->where('is_approved', true)->count();
            $rejectedProducts = Product::where('seller_id', $sellerId)
                ->where('status', 'rejected')->count();
            
            $totalSales = Product::where('seller_id', $sellerId)->sum('sales_count');
            $totalRevenue = Product::where('seller_id', $sellerId)
                ->where('status', 'published')
                ->sum('price');

            // Recent products
            $recentProducts = Product::where('seller_id', $sellerId)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return view('seller.dashboard', compact(
                'totalProducts',
                'pendingProducts',
                'publishedProducts',
                'rejectedProducts',
                'totalSales',
                'totalRevenue',
                'recentProducts'
            ));

        } catch (\Exception $e) {
            Log::error('Seller Dashboard Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load dashboard.');
        }
    }
}