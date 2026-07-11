<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            
            // Relationships
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            
            // Attribute Definition
            $table->string('key'); // pages, duration, isbn, etc.
            $table->string('label'); // Page Count, Duration, ISBN
            $table->enum('type', [
                'text', 'number', 'decimal', 'file', 'select', 
                'multiselect', 'textarea', 'boolean', 'date', 'json'
            ])->default('text');
            
            // Values (different columns for different types)
            $table->text('value_text')->nullable();
            $table->decimal('value_number', 12, 2)->nullable();
            $table->boolean('value_boolean')->nullable();
            $table->date('value_date')->nullable();
            $table->json('value_json')->nullable();
            
            // For select/multiselect
            $table->json('options')->nullable();
            $table->json('selected_options')->nullable();
            
            // For file type
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->string('mime_type')->nullable();
            
            // Display Order
            $table->integer('sort_order')->default(0);
            $table->boolean('is_required')->default(false);
            
            $table->timestamps();
            
            // Indexes
            $table->index('product_id');
            $table->index('category_id');
            $table->index('key');
            $table->unique(['product_id', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};