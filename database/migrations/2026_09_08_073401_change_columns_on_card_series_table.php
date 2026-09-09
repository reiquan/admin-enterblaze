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
        Schema::table('card_series', function (Blueprint $table) {
            // Changes the column type to LONGTEXT
            $table->longText('card_series_description')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_series', function (Blueprint $table) {
            // Reverts the column back to a VARCHAR (default length 255)
            $table->string('card_series_description')->change();
        });
    }
};

