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
        Schema::table('cards', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('card_character_id')->nullable()->after('card_series_id');
            $table->foreign('card_character_id')->references('id')->on('card_characters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            //
            $table->dropColumn('card_character_id');
        });
    }
};
