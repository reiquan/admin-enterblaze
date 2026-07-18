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
        Schema::create('card_locations', function (Blueprint $table) {
            $table->id();
            $table->string('card_location_name');
            $table->unsignedBigInteger('card_location_universe_id');
            $table->string('card_location_environment');
            $table->string('card_location_region');
            $table->json('card_location_bonuses')->nullable();
            $table->timestamps();


            $table->foreign('card_location_universe_id')->references('id')->on('universes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_locations');
    }
};
