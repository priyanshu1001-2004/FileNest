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

            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            $table->string('store_name')->unique();
            $table->string('store_slug')->unique();
            $table->string('store_logo')->nullable();
            $table->string('store_banner')->nullable();
            $table->string('store_tagline', 255)->nullable();
            $table->longText('store_description')->nullable();
            $table->string('support_email')->nullable();
            $table->string('website')->nullable();

            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            $table->string('portfolio_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();

            $table->enum('seller_type', ['individual','business'])->default('individual');
            $table->string('company_name')->nullable();

            $table->text('support_policy')->nullable();
            $table->text('refund_policy')->nullable();
            $table->text('license_information')->nullable();

            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_onboarding_completed')->default(false);

            $table->string('tax_number')->nullable();
            $table->text('business_address')->nullable();
            $table->string('preferred_payout_method')->nullable();
            $table->string('payout_email')->nullable();
            $table->json('bank_details')->nullable();
            $table->longText('admin_notes')->nullable();
            $table->timestamps();
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
