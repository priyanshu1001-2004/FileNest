<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyerDetail extends Model
{
    // Define table name explicitly if needed (Laravel automatically pluralizes, but good practice)
    protected $table = 'buyer_details';

    /**
     * The attributes that are mass assignable.
     * Maps perfectly to migration schema layout matrix.
     */
    protected $fillable = [
        'user_id',
        'display_name',
        'occupation', // Extra field added in dynamic personal details flow
        'bio',
        'country',
        'state',
        'city',
        'preferred_language',
        'preferred_currency',
        'newsletter',
        'is_verified',
        'admin_notes',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'newsletter' => 'boolean',
        'is_verified' => 'boolean',
    ];

    /**
     * Get the user that owns the buyer details dashboard.
     * Inverse relationship mapping to users table framework.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}