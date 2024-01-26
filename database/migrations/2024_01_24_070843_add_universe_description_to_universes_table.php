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
        Schema::table('universes', function (Blueprint $table) {
            //
            $table->string('universe_description')->after('universe_name');
            $table->string('universe_audience')->after('universe_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('universes', function (Blueprint $table) {
            //
            $table->dropColumn('universe_description');
            $table->dropColumn('universe_audience');
        });
    }
};
