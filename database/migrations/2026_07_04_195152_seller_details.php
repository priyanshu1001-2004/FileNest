<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seller_details', function (Blueprint $table) {
            $table->id();

            // ============ USER RELATIONSHIP ============
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            // ============ STORE INFORMATION ============
            $table->string('store_name')->unique()->nullable();
            $table->string('store_slug')->unique();
            $table->string('store_logo')->nullable();
            $table->string('store_banner')->nullable();
            $table->string('store_tagline', 255)->nullable();
            $table->longText('store_description')->nullable();

            // ============ CONTACT INFORMATION ============
            $table->string('support_email')->nullable();
            $table->string('website')->nullable();

            // ============ LOCATION ============
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            // ============ SOCIAL LINKS ============
            $table->string('portfolio_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();

            // ============ SELLER TYPE ============
            $table->enum('seller_type', ['individual', 'business'])->default('individual');
            $table->string('company_name')->nullable();

            // ============ POLICIES ============
            $table->text('support_policy')->nullable();
            $table->text('refund_policy')->nullable();
            $table->text('license_information')->nullable();

            // ============ VERIFICATION & STATUS ============
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_onboarding_completed')->default(false);

            // 🆕 NEW: Suspension Status
            $table->boolean('is_suspended')->default(false);
            $table->timestamp('suspended_until')->nullable();
            $table->text('suspension_reason')->nullable();

            // ============ PERFORMANCE METRICS (🆕 NEW) ============
            $table->decimal('seller_rating', 3, 2)->default(0.00);
            $table->integer('total_sales')->default(0);
            $table->integer('total_products')->default(0);
            $table->integer('total_reviews')->default(0);
            $table->decimal('response_time', 5, 2)->nullable(); // In hours

            // ============ PAYMENT & TAX ============
            $table->string('tax_number')->nullable();
            $table->text('business_address')->nullable();
            $table->string('preferred_payout_method')->nullable();
            $table->string('payout_email')->nullable();
            $table->json('bank_details')->nullable();

            // ============ ADMIN ============
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->longText('admin_notes')->nullable();

            $table->timestamps();

            // ============ INDEXES ============
            $table->index('store_name');
            $table->index('store_slug');
            $table->index('is_verified');
            $table->index('is_suspended');
            $table->index('seller_rating');
            $table->index('total_sales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_details');
    }
};
