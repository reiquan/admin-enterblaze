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
            $table->unsignedBigInteger('card_location_id')->nullable()->after('card_character_id');
            $table->unsignedBigInteger('card_faction_id')->nullable()->after('card_skill_id');


            $table->foreign('card_location_id')->references('id')->on('card_locations');
            $table->foreign('card_faction_id')->references('id')->on('card_factions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            //
            $table->dropColumn('card_location_id');
            $table->dropColumn('card_faction_id');
        });
    }
};
