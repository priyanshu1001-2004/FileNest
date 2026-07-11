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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // ============ RELATIONSHIPS ============
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');

            // ============ BASIC INFORMATION ============
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();

            // ============ PRICING ============
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('compare_price', 12, 2)->nullable();
            $table->decimal('cost_per_item', 12, 2)->nullable();
            $table->decimal('profit_margin', 5, 2)->nullable();

            // ============ MEDIA ============
            $table->string('thumbnail')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('preview_video')->nullable();

            // ============ PRODUCT TYPE ============
            $table->enum('product_type', [
                'ebook',
                'template',
                'video_course',
                'software',
                'design_asset',
                'audio',
                'other'
            ])->default('other');

            // ============ STATUS ============
            $table->enum('status', [
                'draft',
                'pending',
                'published',
                'rejected',
                'archived'
            ])->default('draft');

            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('rejection_reason')->nullable();
            $table->boolean('is_featured')->default(false);

            // ============ INVENTORY ============
            $table->integer('download_limit')->default(5);
            $table->integer('total_downloads')->default(0);
            $table->boolean('is_unlimited')->default(true);

            // ============ DELIVERY ============
            $table->enum('delivery_type', [
                'direct_download',
                'external_link',
                'email_delivery'
            ])->default('direct_download');
            $table->string('external_url')->nullable();

            // ============ PERFORMANCE ============
            $table->integer('view_count')->default(0);
            $table->integer('wishlist_count')->default(0);
            $table->integer('sales_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('review_count')->default(0);

            // ============ SEO ============
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            // ============ AUDIT ============
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            // ============ TIMESTAMPS ============
            $table->timestamps();
            $table->softDeletes();

            // ============ INDEXES ============
            $table->index('seller_id');
            $table->index('category_id');
            $table->index('status');
            $table->index('is_approved');
            $table->index('product_type');
            $table->index('price');
            $table->index('created_at');
            $table->index('sales_count');
            $table->index('average_rating');
            $table->fullText(['title', 'description', 'short_description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
