<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of seller's products.
     */
    public function index()
    {
        try {
            $sellerId = auth()->id();

            $products = Product::with(['category'])
                ->where('seller_id', $sellerId)
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            $totalProducts = Product::where('seller_id', $sellerId)->count();
            $pendingProducts = Product::where('seller_id', $sellerId)
                ->where('status', 'pending')->count();
            $publishedProducts = Product::where('seller_id', $sellerId)
                ->where('status', 'published')
                ->where('is_approved', true)->count();
            $rejectedProducts = Product::where('seller_id', $sellerId)
                ->where('status', 'rejected')->count();

            $categories = Category::where('status', true)->get();

            return view('seller.products.index', compact(
                'products',
                'categories',
                'totalProducts',
                'pendingProducts',
                'publishedProducts',
                'rejectedProducts'
            ));
        } catch (\Exception $e) {
            Log::error('Seller Product Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load products.');
        }
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        try {
            $categories = Category::where('status', true)->get();
            return view('seller.products.create', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Seller Product Create Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load form.');
        }
    }

    /**
     * Get attributes for a category (AJAX).
     */
    public function getAttributes(Category $category)
    {
        try {
            $fields = $category->field_schema ?? [];

            return response()->json([
                'success' => true,
                'fields' => $fields,
            ]);
        } catch (\Exception $e) {
            Log::error('Get Attributes Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load attributes.',
            ], 500);
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
                'price' => 'required|numeric|min:0',
                'compare_price' => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
                'short_description' => 'nullable|string|max:500',
                'product_type' => 'required|string|in:ebook,template,video_course,software,design_asset,audio,other',
                'delivery_type' => 'required|string|in:direct_download,external_link,email_delivery',
                'external_url' => 'nullable|url',
                'download_limit' => 'nullable|integer|min:0',
                'is_unlimited' => 'boolean',
                'attributes' => 'nullable|array',
                'main_file' => 'required_if:delivery_type,direct_download|file|max:20480',
                'preview_file' => 'nullable|file|max:20480',
            ]);

            $validated['seller_id'] = auth()->id();
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
            $validated['created_by'] = auth()->id();
            $validated['updated_by'] = auth()->id();
            $validated['status'] = 'pending';
            $validated['is_approved'] = false;

            $attributes = $request->get('attributes', []);
            unset($validated['attributes']);

            $product = DB::transaction(function () use ($validated, $attributes, $request) {
                $product = Product::create($validated);
                $this->saveAttributes($product, $attributes);
                $this->uploadFiles($product, $request);
                return $product;
            });

            return redirect()
                ->route('seller.products.index')
                ->with('success', "Product '{$product->title}' submitted for review!");
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Seller Product Creation Failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create product. Please try again.');
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        try {
            if ($product->seller_id !== auth()->id()) {
                abort(403, 'Unauthorized access.');
            }

            $product->load(['category', 'attributes', 'files']);

            return view('seller.products.show', compact('product'));
        } catch (\Exception $e) {
            Log::error('Seller Product Show Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load product details.');
        }
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        try {
            // Check if product belongs to seller
            if ($product->seller_id !== auth()->id()) {
                abort(403, 'Unauthorized access.');
            }

            $categories = Category::where('status', true)->get();
            $product->load('attributes');

            // Determine warning message based on status
            $warning = null;
            $canEdit = true;

            if ($product->status === 'published' && $product->is_approved) {
                $warning = '⚠️ This product is live on the platform. Any changes will require admin re-approval.';
            }

            if ($product->status === 'rejected') {
                $warning = '📝 Please fix the issues below and resubmit for review.';
            }

            if ($product->status === 'archived') {
                $warning = '🔒 This product is archived and cannot be edited.';
                $canEdit = false;
            }

            return view('seller.products.edit', compact('product', 'categories', 'warning', 'canEdit'));
        } catch (\Exception $e) {
            Log::error('Seller Product Edit Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load edit form.');
        }
    }


    /**
     * Update the specified product.
     */
    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        try {
            // Check if product belongs to seller
            if ($product->seller_id !== auth()->id()) {
                abort(403, 'Unauthorized access.');
            }

            // Check if product is archived
            if ($product->status === 'archived') {
                return redirect()->route('seller.products.index')
                    ->with('error', 'Archived products cannot be edited.');
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|numeric|min:0',
                'compare_price' => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
                'short_description' => 'nullable|string|max:500',
                'product_type' => 'required|string|in:ebook,template,video_course,software,design_asset,audio,other',
                'delivery_type' => 'required|string|in:direct_download,external_link,email_delivery',
                'external_url' => 'nullable|url',
                'download_limit' => 'nullable|integer|min:0',
                'is_unlimited' => 'boolean',
                'attributes' => 'nullable|array',
                'main_file' => 'nullable|file|max:20480',
                'preview_file' => 'nullable|file|max:20480',
            ]);

            // Update slug if title changed
            if ($product->title !== $validated['title']) {
                $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
            }

            $validated['updated_by'] = auth()->id();

            $requiresReApproval = false;
            $message = 'Product updated successfully!';

            // ============================================
            // CHECK FOR CRITICAL CHANGES (Only for Published products)
            // ============================================
            if ($product->status === 'published' && $product->is_approved) {

                // 1. Check if Category changed
                if ($product->category_id != $validated['category_id']) {
                    $requiresReApproval = true;
                }

                // 2. Check if Product Type changed
                if ($product->product_type != $validated['product_type']) {
                    $requiresReApproval = true;
                }

                // 3. Check if Attributes changed
                $oldAttributes = $product->attributes->pluck('value_text', 'key')->toArray();
                $newAttributes = $request->get('attributes', []);
                foreach ($oldAttributes as $key => $value) {
                    if (isset($newAttributes[$key]) && $newAttributes[$key] != $value) {
                        $requiresReApproval = true;
                        break;
                    }
                }

                // 4. Check if Files changed
                if ($request->hasFile('main_file') || $request->hasFile('preview_file')) {
                    $requiresReApproval = true;
                }

                // Apply status based on changes
                if ($requiresReApproval) {
                    $validated['status'] = 'pending';
                    $validated['is_approved'] = false;
                    $validated['rejection_reason'] = null;
                    $message = 'Product updated. Critical changes detected. Waiting for admin approval.';
                } else {
                    $validated['status'] = 'published';
                    $validated['is_approved'] = true;
                    $message = 'Product updated successfully!';
                }
            }

            // CASE 2: Rejected → Resubmit
            if ($product->status === 'rejected') {
                $validated['status'] = 'pending';
                $validated['is_approved'] = false;
                $validated['rejection_reason'] = null;
                $message = 'Product resubmitted for review.';
            }

            // CASE 3: Pending → Keep pending
            if ($product->status === 'pending') {
                $validated['status'] = 'pending';
                $validated['is_approved'] = false;
                $message = 'Product updated. Waiting for admin review.';
            }

            $attributes = $request->get('attributes', []);
            unset($validated['attributes']);

            $product = DB::transaction(function () use ($product, $validated, $attributes, $request) {
                $product->update($validated);
                $this->saveAttributes($product, $attributes);
                $this->uploadFiles($product, $request);
                return $product->fresh();
            });

            // ✅ FIX: Redirect with success message
            return redirect()
                ->route('seller.products.index')
                ->with('success', $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Seller Product Update Failed: ' . $e->getMessage());
            // ✅ FIX: Redirect back with error
            return redirect()
                ->route('seller.products.index')
                ->with('error', 'Failed to update product. Please try again.');
        }
    }
    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        try {
            // Check if product belongs to seller
            if ($product->seller_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ], 403);
            }

            // ============================================
            // DELETE LOGIC (FINAL DECISION)
            // ============================================

            $productName = $product->title;

            // CASE 1: Published product → Archive (Soft Delete)
            if ($product->status === 'published' && $product->is_approved) {
                $product->status = 'archived';
                $product->save();

                return response()->json([
                    'success' => true,
                    'message' => "Product '{$productName}' has been archived (removed from public view)."
                ]);
            }

            // CASE 2: Draft/Pending/Rejected → Permanent Delete
            if (in_array($product->status, ['draft', 'pending', 'rejected'])) {
                DB::transaction(function () use ($product) {
                    // Delete files from storage
                    foreach ($product->files as $file) {
                        if (Storage::disk('public')->exists($file->file_path)) {
                            Storage::disk('public')->delete($file->file_path);
                        }
                    }
                    $product->delete();
                });

                return response()->json([
                    'success' => true,
                    'message' => "Product '{$productName}' deleted successfully!"
                ]);
            }

            // CASE 3: Archived → Cannot delete
            return response()->json([
                'success' => false,
                'message' => 'Archived products cannot be deleted.'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Seller Product Deletion Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product.',
            ], 500);
        }
    }

    /**
     * Get product attributes for AJAX view.
     */
    public function getProductAttributes(Product $product)
    {
        try {
            if ($product->seller_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ], 403);
            }

            $attributes = $product->attributes->map(function ($attr) {
                return [
                    'key' => $attr->key,
                    'label' => $attr->label,
                    'value' => $attr->getDisplayValue(),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $attributes,
            ]);
        } catch (\Exception $e) {
            Log::error('Get Product Attributes Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load attributes.'
            ], 500);
        }
    }

    /**
     * Get product files for AJAX view.
     */
    public function getProductFiles(Product $product)
    {
        try {
            if ($product->seller_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ], 403);
            }

            $files = $product->files->map(function ($file) {
                return [
                    'id' => $file->id,
                    'original_name' => $file->original_name,
                    'file_type' => $file->file_type,
                    'file_size' => $file->getFileSizeHuman(),
                    'download_count' => $file->download_count,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $files,
            ]);
        } catch (\Exception $e) {
            Log::error('Get Product Files Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load files.'
            ], 500);
        }
    }

    // ==================== PRIVATE HELPERS ====================

    private function saveAttributes(Product $product, array $attributes): void
    {
        $schema = $product->category->field_schema ?? [];
        $product->attributes()->delete();

        foreach ($schema as $key => $field) {
            if (!isset($attributes[$key]) || $attributes[$key] === null || $attributes[$key] === '') {
                continue;
            }

            $data = [
                'product_id' => $product->id,
                'category_id' => $product->category_id,
                'key' => $key,
                'label' => $field['label'] ?? $key,
                'type' => $field['type'] ?? 'text',
                'options' => $field['options'] ?? null,
                'is_required' => $field['required'] ?? false,
            ];

            $type = $field['type'] ?? 'text';

            switch ($type) {
                case 'text':
                case 'textarea':
                    $data['value_text'] = $attributes[$key];
                    break;
                case 'number':
                case 'decimal':
                    $data['value_number'] = $attributes[$key];
                    break;
                case 'boolean':
                    $data['value_boolean'] = filter_var($attributes[$key], FILTER_VALIDATE_BOOLEAN);
                    break;
                case 'select':
                case 'multiselect':
                    $data['selected_options'] = is_array($attributes[$key]) ? $attributes[$key] : [$attributes[$key]];
                    break;
                default:
                    $data['value_text'] = $attributes[$key];
            }

            ProductAttribute::create($data);
        }
    }

    private function uploadFiles(Product $product, Request $request): void
    {
        // Main File
        if ($request->hasFile('main_file')) {
            $file = $request->file('main_file');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('products/' . $product->id . '/files', $fileName, 'public');

            $oldFile = $product->files()->where('file_type', 'main')->first();
            if ($oldFile) {
                if (Storage::disk('public')->exists($oldFile->file_path)) {
                    Storage::disk('public')->delete($oldFile->file_path);
                }
                $oldFile->delete();
            }

            ProductFile::create([
                'product_id' => $product->id,
                'file_name' => $fileName,
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_url' => Storage::url($path),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'file_hash' => hash_file('sha256', $file->getRealPath()),
                'file_type' => 'main',
                'download_limit' => $request->download_limit ?? null,
                'is_protected' => true,
            ]);
        }

        // Preview File
        if ($request->hasFile('preview_file')) {
            $file = $request->file('preview_file');
            $fileName = time() . '_preview_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('products/' . $product->id . '/files', $fileName, 'public');

            $oldFile = $product->files()->where('file_type', 'preview')->first();
            if ($oldFile) {
                if (Storage::disk('public')->exists($oldFile->file_path)) {
                    Storage::disk('public')->delete($oldFile->file_path);
                }
                $oldFile->delete();
            }

            ProductFile::create([
                'product_id' => $product->id,
                'file_name' => $fileName,
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_url' => Storage::url($path),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'file_hash' => hash_file('sha256', $file->getRealPath()),
                'file_type' => 'preview',
                'is_public' => true,
                'is_protected' => false,
            ]);
        }
    }


    /**
     * Archive a product (Remove from public view).
     */
    public function archive(Product $product)
    {
        try {
            if ($product->seller_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ], 403);
            }

            if ($product->status !== 'published' || !$product->is_approved) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only published products can be archived.'
                ], 422);
            }

            $product->status = 'archived';
            $product->save();

            return response()->json([
                'success' => true,
                'message' => "Product '{$product->title}' archived successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error('Archive Product Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to archive product.'
            ], 500);
        }
    }

    /**
     * Unarchive a product (Restore to public view).
     */
    public function unarchive(Product $product)
    {
        try {
            if ($product->seller_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ], 403);
            }

            if ($product->status !== 'archived') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only archived products can be unarchived.'
                ], 422);
            }

            $product->status = 'published';
            $product->is_approved = true;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => "Product '{$product->title}' unarchived successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error('Unarchive Product Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to unarchive product.'
            ], 500);
        }
    }
}
