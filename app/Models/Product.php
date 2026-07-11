<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'seller_id', 'category_id',
        'title', 'slug', 'description', 'short_description',
        'price', 'compare_price', 'cost_per_item', 'profit_margin',
        'thumbnail', 'gallery_images', 'preview_video',
        'product_type',
        'status', 'is_approved', 'approved_at', 'approved_by', 'rejection_reason',
        'is_featured',
        'download_limit', 'total_downloads', 'is_unlimited',
        'delivery_type', 'external_url',
        'view_count', 'wishlist_count', 'sales_count', 'average_rating', 'review_count',
        'meta_title', 'meta_description', 'meta_keywords',
        'created_by', 'updated_by'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost_per_item' => 'decimal:2',
        'profit_margin' => 'decimal:2',
        'average_rating' => 'decimal:2',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'is_unlimited' => 'boolean',
        'download_limit' => 'integer',
        'total_downloads' => 'integer',
        'view_count' => 'integer',
        'wishlist_count' => 'integer',
        'sales_count' => 'integer',
        'review_count' => 'integer',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title) . '-' . Str::random(6);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('title')) {
                $product->slug = Str::slug($product->title) . '-' . Str::random(6);
            }
        });
    }

    // ==================== RELATIONSHIPS ====================
    
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ==================== SCOPES ====================
    
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeBySeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('short_description', 'LIKE', "%{$search}%");
        });
    }

    // ==================== HELPERS ====================
    
    public function getFinalPrice()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getDiscountPercentage()
    {
        if ($this->compare_price && $this->price < $this->compare_price) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return 0;
    }

    public function isFree()
    {
        return $this->price == 0;
    }

    public function isPublished()
    {
        return $this->status === 'published' && $this->is_approved;
    }

    public function getThumbnailUrl()
    {
        return $this->thumbnail ?? '';
    }

    public function getStatusBadge()
    {
        $badges = [
            'draft' => 'bg-secondary',
            'pending' => 'bg-warning',
            'published' => 'bg-success',
            'rejected' => 'bg-danger',
            'archived' => 'bg-dark'
        ];
        
        return $badges[$this->status] ?? 'bg-secondary';
    }

    public function getStatusLabel()
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    
}