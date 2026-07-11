<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    /**
     * Display a listing of categories.
     */
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        try {
            // Get all filter parameters
            $search = $request->get('search');
            $status = $request->get('status');
            $parentId = $request->get('parent_id');
            $dateFilter = $request->get('date_filter');

            // Build query
            $categories = Category::with(['parent', 'children'])
                // Search filter
                ->when($search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('description', 'LIKE', "%{$search}%");
                    });
                })
                // Status filter
                ->when($status, function ($query, $status) {
                    if ($status === 'active') {
                        return $query->where('status', true);
                    } elseif ($status === 'inactive') {
                        return $query->where('status', false);
                    }
                    return $query;
                })
                // Parent category filter
                ->when($parentId !== null && $parentId !== '', function ($query) use ($parentId) {
                    if ($parentId === 'null') {
                        return $query->whereNull('parent_id');
                    }
                    return $query->where('parent_id', $parentId);
                })
                // Date filter
                ->when($dateFilter, function ($query, $dateFilter) {
                    switch ($dateFilter) {
                        case 'today':
                            return $query->whereDate('created_at', today());
                        case 'week':
                            return $query->whereBetween('created_at', [
                                now()->startOfWeek(),
                                now()->endOfWeek()
                            ]);
                        case 'month':
                            return $query->whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year);
                        case 'year':
                            return $query->whereYear('created_at', now()->year);
                        default:
                            return $query;
                    }
                })
                // Order by latest first
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            // ============================================
            // STATISTICS
            // ============================================
            $totalCategories = Category::count();
            $activeCategories = Category::where('status', true)->count();
            $inactiveCategories = Category::where('status', false)->count();
            $rootCategories = Category::whereNull('parent_id')->count();
            $subCategories = Category::whereNotNull('parent_id')->count();


            // Get category options for dropdown
            $categoryOptions = Category::getNestedOptions();

            // Return view with data
            return view('admin.categories.index', compact(
                'categories',
                'categoryOptions',
                'totalCategories',
                'activeCategories',
                'inactiveCategories',
                'rootCategories',
                'subCategories'
            ));
        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Category Index Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            // Return with error message
            return back()->with('error', 'Unable to load categories. Please try again.');
        }
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('categories', 'name'),
                ],
                'slug' => [
                    'nullable',
                    'string',
                    'max:255',
                    'regex:/^[a-z0-9-]+$/',
                    Rule::unique('categories', 'slug'),
                ],
                'description' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
                'parent_id' => [
                    'nullable',
                    'exists:categories,id',
                ],
                'status' => [
                    'required',
                    'boolean',
                ],
            ]);

            if (empty($validatedData['slug'])) {
                $validatedData['slug'] = $this->generateUniqueSlug($validatedData['name']);
            }

            $validatedData['created_by'] = auth()->id();
            $validatedData['updated_by'] = auth()->id();

            $category = DB::transaction(function () use ($validatedData) {
                return Category::create($validatedData);
            });

            return response()->json([
                'success' => true,
                'message' => "Category '{$category->name}' created successfully!",
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                ]
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Category Creation Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create category. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        // Load relationships
        $category->load(['parent', 'children', 'creator', 'updater']);

        // Return HTML view directly (not JSON)
        return view('admin.categories.show', compact('category'));
    }
    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $validatedData = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('categories', 'name')->ignore($category->id),
                ],
                'slug' => [
                    'nullable',
                    'string',
                    'max:255',
                    'regex:/^[a-z0-9-]+$/',
                    Rule::unique('categories', 'slug')->ignore($category->id),
                ],
                'description' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
                'parent_id' => [
                    'nullable',
                    'exists:categories,id',
                    Rule::notIn([$category->id]),
                ],
                'status' => [
                    'required',
                    'boolean',
                ],
            ]);

            if (empty($validatedData['slug'])) {
                $validatedData['slug'] = $this->generateUniqueSlug($validatedData['name']);
            }

            $validatedData['updated_by'] = auth()->id();

            $category = DB::transaction(function () use ($category, $validatedData) {
                $category->update($validatedData);
                return $category->fresh();
            });

            return response()->json([
                'success' => true,
                'message' => "Category '{$category->name}' updated successfully!",
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Category Update Failed', [
                'error' => $e->getMessage(),
                'category_id' => $category->id,
                'request' => $request->all(),
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update category. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        try {
            // Check if category has children
            if ($category->children()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete category with sub-categories. Please delete children first.',
                ], 422);
            }

            $categoryName = $category->name;

            DB::transaction(function () use ($category) {
                $category->delete();
            });

            return response()->json([
                'success' => true,
                'message' => "Category '{$categoryName}' deleted successfully!",
            ]);
        } catch (\Exception $e) {
            Log::error('Category Deletion Failed', [
                'error' => $e->getMessage(),
                'category_id' => $category->id,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }


    /**
     * Generate a unique slug.
     */
    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
