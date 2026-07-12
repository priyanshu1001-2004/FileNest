<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of products (Admin Review).
     */
    public function index(Request $request)
    {
        try {
            $search = $request->get('search');
            $status = $request->get('status');
            $categoryId = $request->get('category_id');
            $productType = $request->get('product_type');

            $products = Product::with(['seller', 'category'])
                ->when($search, function ($query, $search) {
                    return $query->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                })
                ->when($status, function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->when($categoryId, function ($query, $categoryId) {
                    return $query->where('category_id', $categoryId);
                })
                ->when($productType, function ($query, $productType) {
                    return $query->where('product_type', $productType);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            // Statistics
            $totalProducts = Product::count();
            $pendingProducts = Product::where('status', 'pending')->count();
            $approvedProducts = Product::where('status', 'published')->where('is_approved', true)->count();
            $rejectedProducts = Product::where('status', 'rejected')->count();
            $featuredProducts = Product::where('is_featured', true)->count();

            $categories = Category::where('status', true)->get();
            $sellers = User::where('role', 1)->get();

            return view('admin.products.index', compact(
                'products',
                'categories',
                'sellers',
                'totalProducts',
                'pendingProducts',
                'approvedProducts',
                'rejectedProducts',
                'featuredProducts'
            ));
        } catch (\Exception $e) {
            Log::error('Product Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load products.');
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        try {
            $product->load(['seller', 'category', 'attributes', 'files', 'approvedBy', 'creator', 'updater']);

            return view('admin.products.show', compact('product'));
        } catch (\Exception $e) {
            Log::error('Product Show Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load product details.');
        }
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Request $request, Product $product)
    {
        try {
            $productName = $product->title;

            DB::transaction(function () use ($product) {
                // Delete associated files from storage
                foreach ($product->files as $file) {
                    if (\Storage::disk('public')->exists($file->file_path)) {
                        \Storage::disk('public')->delete($file->file_path);
                    }
                }
                $product->delete();
            });

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Product '{$productName}' deleted successfully!"
                ]);
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', "Product '{$productName}' deleted successfully!");
        } catch (\Exception $e) {
            Log::error('Product Deletion Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product.'
            ], 500);
        }
    }



    /**
     * Approve a product.
     */
    public function approve(Product $product)
    {
        try {
            $product->status = 'published';
            $product->is_approved = true;
            $product->approved_at = now();
            $product->approved_by = auth()->id();
            $product->rejection_reason = null;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => "Product '{$product->title}' approved successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error('Product Approval Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve product.'
            ], 500);
        }
    }

    /**
     * Reject a product.
     */
    public function reject(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'rejection_reason' => 'required|string|max:500'
            ]);

            $product->status = 'rejected';
            $product->is_approved = false;
            $product->rejection_reason = $validated['rejection_reason'];
            $product->save();

            return response()->json([
                'success' => true,
                'message' => "Product '{$product->title}' rejected successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error('Product Rejection Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject product.'
            ], 500);
        }
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Product $product)
    {
        try {
            $product->is_featured = !$product->is_featured;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => "Product '{$product->title}' " . ($product->is_featured ? 'featured' : 'unfeatured') . " successfully!",
                'is_featured' => $product->is_featured
            ]);
        } catch (\Exception $e) {
            Log::error('Product Featured Toggle Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update featured status.'
            ], 500);
        }
    }
}