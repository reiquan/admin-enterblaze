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
        Schema::create('card_series', function (Blueprint $table) {
            $table->id();
            $table->string('card_series_name');
            $table->unsignedBigInteger('card_series_universe_id');
            $table->unsignedBigInteger('card_series_book_id')->nullable();
            $table->string('card_series_description');
            $table->string('card_series_is_active')->nullable();
            $table->timestamps();


            $table->foreign('card_series_universe_id')->references('id')->on('universes');
            $table->foreign('card_series_book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_series');
    }
};
