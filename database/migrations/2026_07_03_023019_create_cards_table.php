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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('card_series_id');
            $table->unsignedBigInteger('card_era_id');
            $table->string('card_name');
            $table->unsignedBigInteger('card_type_id');
            $table->string('card_slug');
            $table->string('card_rarity');
            $table->unsignedBigInteger('card_tier_id');
            $table->string('card_bio');
            $table->string('card_image_one');
            $table->string('card_image_two')->nullable();
            $table->string('card_is_published');
            $table->json('card_tags')->nullable();
            $table->timestamps();


            $table->foreign('card_series_id')->references('id')->on('card_series');
            $table->foreign('card_type_id')->references('id')->on('card_types');
            $table->foreign('card_era_id')->references('id')->on('card_eras');
            $table->foreign('card_tier_id')->references('id')->on('card_tiers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
