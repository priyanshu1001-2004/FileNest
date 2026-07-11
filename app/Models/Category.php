<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'status',
        'field_schema',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'status' => 'boolean',
        'field_schema' => 'array',
        'parent_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the parent category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get the user who created the category.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the category.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ==================== SCOPES (Query Filters) ====================

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include root categories (no parent).
     */
    public function scopeRootCategories(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope a query to search categories.
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope a query to get categories by slug.
     */
    public function scopeWhereSlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Get the category hierarchy as a string.
     * Example: "Electronics > Computers > Laptops"
     */
    public function getHierarchyAttribute(): string
    {
        $hierarchy = [$this->name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($hierarchy, $parent->name);
            $parent = $parent->parent;
        }

        return implode(' > ', $hierarchy);
    }

    /**
     * Check if category has children.
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Check if category can be deleted.
     */
    public function canDelete(): bool
    {
        return !$this->hasChildren();
    }

    /**
     * Get all descendant category IDs.
     */
    public function getDescendantIds(): array
    {
        $ids = [];
        $this->load('children');

        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getDescendantIds());
        }

        return $ids;
    }

    /**
     * Get the category tree for display.
     */
    public static function getTree(): array
    {
        return self::with('children')
            ->whereNull('parent_id')
            ->where('status', true)
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    /**
     * Get nested categories for select dropdown.
     */
    public static function getNestedOptions(int $excludeId = null): array
    {
        $categories = self::where('status', true)
            ->when($excludeId, function ($query) use ($excludeId) {
                return $query->where('id', '!=', $excludeId);
            })
            ->orderBy('name')
            ->get();

        return self::buildNestedOptions($categories);
    }

    /**
     * Build nested options for select dropdown.
     */
    private static function buildNestedOptions($categories, $parentId = null, $prefix = ''): array
    {
        $options = [];

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $options[$category->id] = $prefix . $category->name;
                
                $children = self::buildNestedOptions(
                    $categories,
                    $category->id,
                    $prefix . '— '
                );
                
                $options = $options + $children;
            }
        }

        return $options;
    }

    /**
     * Generate unique slug.
     */
    public static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $count = self::where('slug', 'LIKE', "{$slug}%")->count();

        return $count > 0 ? "{$slug}-{$count}" : $slug;
    }

    // ==================== FIELD SCHEMA METHODS (Hybrid Approach) ====================

    /**
     * Get field schema or empty array.
     */
    public function getFieldSchema(): array
    {
        return $this->field_schema ?? [];
    }

    /**
     * Check if category has custom fields.
     */
    public function hasCustomFields(): bool
    {
        return !empty($this->field_schema);
    }

    /**
     * Get required fields from schema.
     */
    public function getRequiredFields(): array
    {
        $schema = $this->getFieldSchema();
        return array_keys(array_filter($schema, fn($field) => $field['required'] ?? false));
    }

    /**
     * Get field types from schema.
     */
    public function getFieldTypes(): array
    {
        $schema = $this->getFieldSchema();
        return array_map(fn($field) => $field['type'] ?? 'text', $schema);
    }

    /**
     * Check if category uses separate table (for complex categories).
     */
    public function usesSeparateTable(): bool
    {
        return $this->field_schema['use_separate_table'] ?? false;
    }

    /**
     * Get the separate table name for complex categories.
     */
    public function getSeparateTableName(): ?string
    {
        if ($this->usesSeparateTable()) {
            return $this->slug . '_details';
        }
        return null;
    }

    // ==================== PRODUCT RELATIONSHIP ====================

    /**
     * Get the products for this category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Count products in this category.
     */
    public function getProductCountAttribute(): int
    {
        return $this->products()->count();
    }
}