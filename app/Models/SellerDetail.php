<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_name',
        'store_slug',
        'store_logo',
        'store_banner',
        'store_tagline',
        'store_description',
        'support_email',
        'website',
        'country',
        'state',
        'city',
        'portfolio_url',
        'github_url',
        'youtube_url',
        'linkedin_url',
        'twitter_url',
        'instagram_url',
        'seller_type',
        'company_name',
        'support_policy',
        'refund_policy',
        'license_information',
        'is_verified',
        'is_featured',
        'is_onboarding_completed',
        'is_suspended',
        'suspended_until',
        'suspension_reason',
        'seller_rating',
        'total_sales',
        'total_products',
        'total_reviews',
        'response_time',
        'tax_number',
        'business_address',
        'preferred_payout_method',
        'payout_email',
        'bank_details',
        'verified_by',
        'admin_notes',
    ];

    protected $casts = [
        'bank_details' => 'array',
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
        'is_onboarding_completed' => 'boolean',
        'is_suspended' => 'boolean',
        'suspended_until' => 'datetime',
        'seller_rating' => 'decimal:2',
        'response_time' => 'decimal:2',
    ];

    // ==================== RELATIONSHIPS ====================
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id', 'user_id');
    }

    // ==================== SCOPES ====================
    
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_verified', true)->where('is_suspended', false);
    }

    public function scopeSuspended($query)
    {
        return $query->where('is_suspended', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_verified', false);
    }

    // ==================== HELPERS ====================
    
    public function getFullStoreName(): string
    {
        if ($this->seller_type === 'business' && $this->company_name) {
            return $this->store_name . ' (' . $this->company_name . ')';
        }
        return $this->store_name;
    }

    public function getRatingStars(): int
    {
        return round($this->seller_rating ?? 0);
    }

    public function isActive(): bool
    {
        return $this->is_verified && !$this->is_suspended;
    }

    public function getStoreLogoUrl(): string
    {
        return $this->store_logo 
            ? asset('storage/' . $this->store_logo) 
            : asset('images/default-store.png');
    }

    public function getStoreBannerUrl(): string
    {
        return $this->store_banner 
            ? asset('storage/' . $this->store_banner) 
            : asset('images/default-banner.png');
    }

    public function getTotalEarnings(): float
    {
        return $this->products()->where('status', 'published')->sum('price') ?? 0;
    }

    public function getSocialLinks(): array
    {
        $links = [];
        
        if ($this->portfolio_url) $links['Portfolio'] = $this->portfolio_url;
        if ($this->github_url) $links['GitHub'] = $this->github_url;
        if ($this->youtube_url) $links['YouTube'] = $this->youtube_url;
        if ($this->linkedin_url) $links['LinkedIn'] = $this->linkedin_url;
        if ($this->twitter_url) $links['Twitter'] = $this->twitter_url;
        if ($this->instagram_url) $links['Instagram'] = $this->instagram_url;
        
        return $links;
    }

    public function getStatusBadge(): string
    {
        if ($this->is_suspended) {
            return 'danger';
        }
        if ($this->is_verified) {
            return 'success';
        }
        return 'warning';
    }

    public function getStatusLabel(): string
    {
        if ($this->is_suspended) {
            return 'Suspended';
        }
        if ($this->is_verified) {
            return 'Active';
        }
        return 'Pending';
    }

    public function getSellerTypeLabel(): string
    {
        return ucfirst(str_replace('_', ' ', $this->seller_type ?? 'individual'));
    }

    public function isSuspended(): bool
    {
        if (!$this->is_suspended) {
            return false;
        }
        
        // Check if suspension has expired
        if ($this->suspended_until && $this->suspended_until->isPast()) {
            $this->is_suspended = false;
            $this->suspension_reason = null;
            $this->suspended_until = null;
            $this->save();
            return false;
        }
        
        return true;
    }

    public function updateMetrics(): void
    {
        $this->total_products = $this->products()->count();
        $this->total_sales = $this->products()->sum('sales_count');
        $this->total_reviews = $this->products()->sum('review_count');
        $this->save();
    }
}