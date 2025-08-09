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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->decimal('commission_amount', 10, 2)->nullable();
            $table->decimal('commission_rate', 5, 2);
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->json('customer_data')->nullable()->comment('Additional customer information');
            $table->timestamps();
            
            // Add indexes for performance
            $table->index('affiliate_id');
            $table->index('program_id');
            $table->index('status');
            $table->index('customer_email');
            $table->index(['affiliate_id', 'status']);
            $table->index('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};