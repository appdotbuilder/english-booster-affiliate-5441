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
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->enum('method', ['bank_transfer', 'paypal', 'e_wallet', 'crypto'])->default('bank_transfer');
            $table->json('payment_details')->nullable()->comment('Payment method specific details');
            $table->timestamp('processed_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamps();
            
            // Add indexes for performance
            $table->index('affiliate_id');
            $table->index('status');
            $table->index('processed_at');
            $table->index(['affiliate_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payouts');
    }
};