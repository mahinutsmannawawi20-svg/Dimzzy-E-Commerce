<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // GAME-XXXXX
            $table->string('player_name', 100);
            $table->enum('game_type', ['pingpong', 'snake']);
            $table->integer('score');
            $table->integer('discount_percentage'); // 5-45%
            $table->decimal('min_purchase', 12, 2)->default(10000); // Minimum Rp 10,000
            $table->boolean('is_used')->default(false);
            $table->timestamp('used_at')->nullable();
            $table->timestamp('expired_at');
            $table->timestamps();

            // Indexes for performance
            $table->index('code');
            $table->index('player_name');
            $table->index(['is_used', 'expired_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
