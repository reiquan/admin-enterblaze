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
            $table->string('card_skill_condition')->nullable()->after('card_skill_type_id');
            $table->string('card_skill_is_active')->nullable()->after('card_skill_condition');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_skills', function (Blueprint $table) {
            //
            $table->dropColumn('card_skill_condition');
            $table->dropColumn('card_skill_is_active');
        });
    }
};
