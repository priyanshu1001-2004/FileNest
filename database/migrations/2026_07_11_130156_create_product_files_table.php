<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_files', function (Blueprint $table) {
            $table->id();
            
            // Relationship
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // File Information
            $table->string('file_name'); // Stored file name
            $table->string('original_name'); // Original uploaded name
            $table->string('file_path'); // Storage path
            $table->string('file_url')->nullable(); // Public URL
            $table->bigInteger('file_size')->nullable(); // Size in bytes
            $table->string('mime_type')->nullable(); // File MIME type
            $table->string('file_hash')->nullable(); // SHA256 hash for deduplication
            
            // File Type
            $table->enum('file_type', [
                'main',        // Primary product file
                'preview',     // Preview/demo file
                'sample',      // Sample file
                'source',      // Source files
                'documentation', // Documentation
                'update',      // Update file
                'thumbnail',   // Thumbnail image
                'screenshot'   // Screenshot
            ])->default('main');
            
            // Access Control
            $table->boolean('is_protected')->default(true); // Needs authentication
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(false); // Public preview files
            
            // Download Tracking
            $table->integer('download_limit')->nullable(); // Per buyer
            $table->integer('download_count')->default(0); // Total downloads
            $table->timestamp('last_downloaded_at')->nullable();
            
            // File Metadata
            $table->integer('width')->nullable(); // For images
            $table->integer('height')->nullable(); // For images
            $table->integer('duration_seconds')->nullable(); // For videos/audio
            $table->json('file_metadata')->nullable(); // Additional metadata
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('product_id');
            $table->index('file_type');
            $table->index('file_hash');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_files');
    }
};