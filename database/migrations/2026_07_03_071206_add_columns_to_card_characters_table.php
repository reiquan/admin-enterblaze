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
        Schema::table('card_characters', function (Blueprint $table) {
            //
            $table->integer('card_character_mental')->nullable();
            $table->integer('card_character_physical')->nullable();
            $table->integer('card_character_spiritual')->nullable();
            $table->dropColumn('card_character_tags');
            $table->json('card_character_abilities')->nullable();
            $table->string('card_character_bio');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_characters', function (Blueprint $table) {
            //
            $table->dropColumn('card_character_mental');
            $table->dropColumn('card_character_physical');
            $table->dropColumn('card_character_spiritual');
            $table->addColumn('card_character_tags');
            $table->dropColumn('card_character_abilities');
            $table->dropColumn('card_character_bio');
        });
    }
};
