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

        // Store Information
        'store_name',
        'store_slug',
        'store_logo',
        'store_banner',
        'store_tagline',
        'store_description',

        // Contact
        'support_email',
        'website',

        // Location
        'country',
        'state',
        'city',

        // Social Links
        'portfolio_url',
        'github_url',
        'youtube_url',
        'linkedin_url',
        'twitter_url',
        'instagram_url',

        // Business
        'seller_type',
        'company_name',

        // Policies
        'support_policy',
        'refund_policy',
        'license_information',

        // Status
        'is_verified',
        'is_featured',
        'is_onboarding_completed',

        // Admin
        'tax_number',
        'business_address',
        'preferred_payout_method',
        'payout_email',
        'bank_details',
        'admin_notes',
    ];

    protected $casts = [
        'bank_details' => 'array',
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
        'is_onboarding_completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
