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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'affiliate'])->default('affiliate')->after('email');
            $table->string('referral_code')->unique()->nullable()->after('role');
            $table->decimal('commission_rate', 5, 2)->default(10.00)->after('referral_code')->comment('Commission percentage rate');
            $table->boolean('is_active')->default(true)->after('commission_rate');
            $table->text('bio')->nullable()->after('is_active');
            $table->string('phone')->nullable()->after('bio');
            
            // Add indexes for performance
            $table->index('role');
            $table->index('referral_code');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'referral_code', 
                'commission_rate',
                'is_active',
                'bio',
                'phone'
            ]);
        });
    }
};