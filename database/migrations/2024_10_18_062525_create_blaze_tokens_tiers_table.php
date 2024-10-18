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
        Schema::create('blaze_tokens_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('token_tier_name');
            $table->string('token_tier_description');
            $table->string('token_tier_amount');
            $table->string('token_tier_usd_price');
            $table->string('token_tier_is_active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blaze_tokens_tiers');
    }
};