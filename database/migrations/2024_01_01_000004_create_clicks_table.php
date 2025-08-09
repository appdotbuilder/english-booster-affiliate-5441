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
        Schema::create('clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('program_id')->nullable()->constrained('programs')->onDelete('set null');
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->string('referrer_url')->nullable();
            $table->string('landing_page')->nullable();
            $table->json('metadata')->nullable()->comment('Additional tracking data');
            $table->timestamps();
            
            // Add indexes for performance
            $table->index('affiliate_id');
            $table->index('program_id');
            $table->index('created_at');
            $table->index(['affiliate_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clicks');
    }
};