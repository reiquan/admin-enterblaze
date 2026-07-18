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
        Schema::table('card_skills', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('card_skill_card_id')->nullable()->after('card_skill_condition');
            $table->foreign('card_skill_card_id')->references('id')->on('cards');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_skills', function (Blueprint $table) {
            //
            $table->dropColumn('card_skill_card_id');
            $table->dropForeign('card_skill_card_id');
        });
    }
};
