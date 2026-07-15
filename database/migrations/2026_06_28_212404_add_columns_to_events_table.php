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
        Schema::table('events', function (Blueprint $table) {
            //
            $table->string('subtitle')->nullable()->after('event_promo_image');
            $table->integer('price')->nullable()->after('event_about');
            $table->string('venue')->nullable()->after('host_user_id');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
            $table->dropColumn('subtitle');
            $table->dropColumn('price');
            $table->dropColumn('venue');
        });
    }
};
