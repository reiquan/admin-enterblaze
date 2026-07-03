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
        Schema::create('card_types', function (Blueprint $table) {
            $table->id();
            $table->string('card_type_name');
            $table->string('card_type_description')->nullable();
            $table->integer('card_type_is_active');
            $table->timestamps();
        });

        DB::table('card_types')->insert([
            ['card_type_name' => 'Character', 'card_type_description' => null, 'card_type_is_active' => 1, 'created_at' => now()],
            ['card_type_name' => 'Skill', 'card_type_description' => null, 'card_type_is_active' => 1, 'created_at' => now()],
            ['card_type_name' => 'Weapon', 'card_type_description' => null, 'card_type_is_active' => 1, 'created_at' => now()],
            ['card_type_name' => 'Item', 'card_type_description' => null, 'card_type_is_active' => 1, 'created_at' => now()],
            ['card_type_name' => 'Location', 'card_type_description' => null, 'card_type_is_active' => 1, 'created_at' => now()],
            ['card_type_name' => 'Faction', 'card_type_description' => null, 'card_type_is_active' => 1, 'created_at' => now()],
            ['card_type_name' => 'Creature', 'card_type_description' => null, 'card_type_is_active' => 1, 'created_at' => now()],
            ['card_type_name' => 'Vehicle', 'card_type_description' => null, 'card_type_is_active' => 1, 'created_at' => now()],
            ['card_type_name' => 'Event', 'card_type_description' => null, 'card_type_is_active' => 1, 'created_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_types');
    }
};
