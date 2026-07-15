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
        Schema::create('card_factions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('card_faction_universe_id');
            $table->string('card_faction_name');
            $table->string('card_faction_leader');
            $table->string('card_faction_alignment');
            $table->string('card_faction_influence');
            $table->string('card_faction_military_power');
            $table->string('card_faction_wealth');
            $table->string('card_faction_territory');
            $table->json('card_faction_bonuses')->nullable();
            $table->timestamps();


            $table->foreign('card_faction_universe_id')->references('id')->on('universes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_factions');
    }
};
