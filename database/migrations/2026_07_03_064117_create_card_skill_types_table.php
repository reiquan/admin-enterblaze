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
        Schema::create('card_skill_types', function (Blueprint $table) {
            $table->id();
            $table->string('card_skill_type_name');
            $table->timestamps();
        });
        DB::table('card_skill_types')->insert([
            ['card_skill_type_name' => 'Attack', 'created_at' => now()],
            ['card_skill_type_name' => 'Defense', 'created_at' => now()],
            ['card_skill_type_name' => 'Support', 'created_at' => now()],
            ['card_skill_type_name' => 'Transformation', 'created_at' => now()],
            ['card_skill_type_name' => 'Passive', 'created_at' => now()],
            ['card_skill_type_name' => 'Ultimate', 'created_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_skill_types');
    }
};
