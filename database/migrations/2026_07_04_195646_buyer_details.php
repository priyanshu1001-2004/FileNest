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
        Schema::create('buyer_details', function (Blueprint $table) {
            $table->id();

            // User Relationship
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            $table->string('display_name')->nullable();
            $table->text('bio')->nullable();

            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            $table->string('preferred_language')->default('English');
            $table->string('preferred_currency')->default('USD');

            $table->boolean('newsletter')->default(true);
            $table->boolean('is_verified')->default(false);

            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_details');
    }
};
