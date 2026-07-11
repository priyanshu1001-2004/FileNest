<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User; 

use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
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
            $publishedProducts = Product::where('status', 'published')->count();
            $pendingProducts = Product::where('status', 'pending')->count();
            $featuredProducts = Product::where('is_featured', true)->count();
            $sellers = User::where('role', 2)->get();


            $categories = Category::where('status', true)->get();

            return view('admin.products.index', compact(
                'products',
                'categories',
                'totalProducts',
                'publishedProducts',
                'pendingProducts',
                'featuredProducts', 
                'sellers',
            ));
        } catch (\Exception $e) {
            Log::error('Product Index Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Unable to load products. Please try again.');
        }
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        try {
            $categories = Category::where('status', true)->get();
            $sellers = \App\Models\User::where('role', 'seller')->get();

            return view('admin.products.create', compact('categories', 'sellers'));
        } catch (\Exception $e) {
            Log::error('Product Create Error', [
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Unable to load product creation form.');
        }
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'seller_id' => 'required|exists:users,id',
                'price' => 'required|numeric|min:0',
                'compare_price' => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
                'short_description' => 'nullable|string|max:500',
                'product_type' => 'required|string|in:ebook,template,video_course,software,design_asset,audio,other',
                'status' => 'required|string|in:draft,pending,published,rejected,archived',
                'delivery_type' => 'required|string|in:direct_download,external_link,email_delivery',
                'external_url' => 'nullable|url',
                'download_limit' => 'nullable|integer|min:0',
                'is_unlimited' => 'boolean',
                'is_featured' => 'boolean',
            ]);

            // Generate slug
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);

            // Add audit
            $validated['created_by'] = auth()->id();
            $validated['updated_by'] = auth()->id();

            $product = DB::transaction(function () use ($validated) {
                return Product::create($validated);
            });

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Product '{$product->title}' created successfully!",
                    'product' => $product
                ]);
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', "Product '{$product->title}' created successfully!");
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Product Creation Failed', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
                'user_id' => auth()->id(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create product. Please try again.',
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Failed to create product. Please try again.');
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        try {
            $product->load(['seller', 'category', 'approvedBy', 'creator', 'updater']);

            return view('admin.products.show', compact('product'));
        } catch (\Exception $e) {
            Log::error('Product Show Error', [
                'error' => $e->getMessage(),
                'product_id' => $product->id,
            ]);

            return back()->with('error', 'Unable to load product details.');
        }
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        try {
            $categories = Category::where('status', true)->get();
            $sellers = \App\Models\User::where('role', 'seller')->get();

            return view('admin.products.edit', compact('product', 'categories', 'sellers'));
        } catch (\Exception $e) {
            Log::error('Product Edit Error', [
                'error' => $e->getMessage(),
                'product_id' => $product->id,
            ]);

            return back()->with('error', 'Unable to load edit form.');
        }
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'seller_id' => 'required|exists:users,id',
                'price' => 'required|numeric|min:0',
                'compare_price' => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
                'short_description' => 'nullable|string|max:500',
                'product_type' => 'required|string|in:ebook,template,video_course,software,design_asset,audio,other',
                'status' => 'required|string|in:draft,pending,published,rejected,archived',
                'delivery_type' => 'required|string|in:direct_download,external_link,email_delivery',
                'external_url' => 'nullable|url',
                'download_limit' => 'nullable|integer|min:0',
                'is_unlimited' => 'boolean',
                'is_featured' => 'boolean',
            ]);

            // Update slug if title changed
            if ($product->title !== $validated['title']) {
                $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
            }

            // Add audit
            $validated['updated_by'] = auth()->id();

            $product = DB::transaction(function () use ($product, $validated) {
                $product->update($validated);
                return $product->fresh();
            });

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Product '{$product->title}' updated successfully!",
                    'product' => $product
                ]);
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', "Product '{$product->title}' updated successfully!");
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Product Update Failed', [
                'error' => $e->getMessage(),
                'product_id' => $product->id,
                'request' => $request->all(),
                'user_id' => auth()->id(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update product. Please try again.',
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Failed to update product. Please try again.');
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
            Log::error('Product Deletion Failed', [
                'error' => $e->getMessage(),
                'product_id' => $product->id,
                'user_id' => auth()->id(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete product. Please try again.',
                ], 500);
            }

            return back()->with('error', 'Failed to delete product. Please try again.');
        }
    }

    /**
     * Toggle product status (approve/reject)
     */
    public function toggleStatus(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|string|in:published,rejected,draft,pending'
            ]);

            $product->status = $validated['status'];
            $product->updated_by = auth()->id();

            if ($validated['status'] === 'published') {
                $product->is_approved = true;
                $product->approved_at = now();
                $product->approved_by = auth()->id();
                $product->rejection_reason = null;
            } elseif ($validated['status'] === 'rejected') {
                $product->is_approved = false;
                $product->rejection_reason = $request->get('rejection_reason', 'Product rejected by admin');
            }

            $product->save();

            return response()->json([
                'success' => true,
                'message' => "Product status updated to '{$validated['status']}' successfully!",
                'status' => $product->status,
                'is_approved' => $product->is_approved
            ]);
        } catch (\Exception $e) {
            Log::error('Product Toggle Status Failed', [
                'error' => $e->getMessage(),
                'product_id' => $product->id,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update product status.',
            ], 500);
        }
    }
}
