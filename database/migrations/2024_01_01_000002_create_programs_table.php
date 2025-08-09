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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['online', 'offline', 'rombongan', 'cabang']);
            $table->string('duration')->comment('e.g., 2 weeks, 1 month, 3 months');
            $table->decimal('price', 10, 2);
            $table->decimal('commission_rate', 5, 2)->nullable()->comment('Program-specific commission rate (overrides default)');
            $table->boolean('is_active')->default(true);
            $table->json('features')->nullable()->comment('Program features/benefits');
            $table->string('image_url')->nullable();
            $table->timestamps();
            
            // Add indexes for performance
            $table->index('type');
            $table->index('is_active');
            $table->index(['type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};