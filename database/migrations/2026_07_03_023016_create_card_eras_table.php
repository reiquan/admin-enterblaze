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
        Schema::create('card_eras', function (Blueprint $table) {
            $table->id();
            $table->string('card_era_name');
            $table->string('card_era_description')->nullable();
            $table->integer('card_era_power_scale_multiplier');

            $table->timestamps();
        });

        DB::table('card_eras')->insert([
            ['card_era_name' => 'Medieval Fantasy', 'card_era_description' => null, 'card_era_power_scale_multiplier' => 1, 'created_at' => now()],
            ['card_era_name' => 'Modern Day', 'card_era_description' => null, 'card_era_power_scale_multiplier' => 1, 'created_at' => now()],
            ['card_era_name' => 'Age of the Gods', 'card_era_description' => null, 'card_era_power_scale_multiplier' => 10, 'created_at' => now()],
            ['card_era_name' => 'Galactic Age', 'card_era_description' => null, 'card_era_power_scale_multiplier' => 100, 'created_at' => now()],
            ['card_era_name' => 'Cosmic Age', 'card_era_description' => null, 'card_era_power_scale_multiplier' => 1000, 'created_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_eras');
    }
};
