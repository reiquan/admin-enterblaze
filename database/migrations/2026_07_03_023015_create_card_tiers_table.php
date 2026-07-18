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
        Schema::create('card_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('card_tier_name');
            $table->string('card_tier_is_active');
            $table->integer('card_tier_skill_points')->nullable();
            $table->timestamps();

        });
        DB::table('card_tiers')->insert([
            ['card_tier_name' => 'Civilian', 'card_tier_is_active' => 1, 'card_tier_skill_points' =>'100', 'created_at' => now()],
            ['card_tier_name' => 'Fighter', 'card_tier_is_active' => 1, 'card_tier_skill_points' =>'300', 'created_at' => now()],
            ['card_tier_name' => 'Elite', 'card_tier_is_active' => 1, 'card_tier_skill_points' =>'500', 'created_at' => now()],
            ['card_tier_name' => 'Champion', 'card_tier_is_active' => 1, 'card_tier_skill_points' =>'700', 'created_at' => now()],
            ['card_tier_name' => 'Hero', 'card_tier_is_active' => 1, 'card_tier_skill_points' =>'900', 'created_at' => now()],
            ['card_tier_name' => 'Legendary', 'card_tier_is_active' => 1, 'card_tier_skill_points' =>'1100', 'created_at' => now()],
            ['card_tier_name' => 'Mythic', 'card_tier_is_active' => 1, 'card_tier_skill_points' =>'1300', 'created_at' => now()],
            ['card_tier_name' => 'Divine', 'card_tier_is_active' => 1, 'card_tier_skill_points' =>'1500', 'created_at' => now()],
            ['card_tier_name' => 'Cosmic', 'card_tier_is_active' => 1, 'card_tier_skill_points' =>'1700', 'created_at' => now()],
            ['card_tier_name' => 'Omniversal', 'card_tier_is_active' => 1, 'card_tier_skill_points' =>'2000', 'created_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_tiers');
    }
};
