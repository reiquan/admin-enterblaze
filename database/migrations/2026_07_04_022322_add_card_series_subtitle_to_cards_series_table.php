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
            //
            $table->dropColumn('card_series_image');
            $table->unsignedBigInteger('card_series_era_id')->after('card_series_universe_id');
            $table->string('card_series_subtitle')->after('card_series_name');
            $table->string('card_series_image_front')->nulable()->after('card_series_is_active');
            $table->string('card_series_image_back')->nullable()->after('card_series_image_front');
            
            $table->datetime('card_series_published_at');

            $table->foreign('card_series_era_id')->references('id')->on('card_eras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_series', function (Blueprint $table) {
            //
            $table->string('card_series_image');
            $table->dropColumn('card_series_subtitle');
            $table->dropForeign('card_series_era_id');
            $table->dropColumn('card_series_image_front');
            $table->dropColumn('card_series_published_at');
        });
    }
};
