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
        Schema::table('blaze_tokens_tiers', function (Blueprint $table) {
            //
            $table->string('tag')->nullable()->after('token_tier_usd_price');
            $table->boolean('featured')->nullable()->after('token_tier_usd_price');
            $table->json('perks')->nullable()->after('token_tier_usd_price'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blaze_tokens_tiers', function (Blueprint $table) {
            //
            $table->dropColumn('tag');
            $table->dropColumn('featured');
            $table->dropColumn('perks'); 
        });
    }
};
