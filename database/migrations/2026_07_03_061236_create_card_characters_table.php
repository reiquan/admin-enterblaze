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
        Schema::create('card_characters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('card_character_universe_id');
            $table->string('card_character_name');
            $table->string('card_character_alias');
            $table->string('card_character_race');
            $table->string('card_character_gender');
            $table->string('card_character_age');
            $table->string('card_character_affiliation');
            $table->string('card_character_occupation');
            $table->string('card_character_is_published')->nullable();
            $table->json('card_character_tags')->nullable();
            $table->timestamps();

            $table->foreign('card_character_universe_id')->references('id')->on('universes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_characters');
    }
};
