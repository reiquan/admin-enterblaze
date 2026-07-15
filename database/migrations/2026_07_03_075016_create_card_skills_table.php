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
        Schema::create('card_skills', function (Blueprint $table) {
            $table->id();
            $table->string('card_skill_name');
            $table->unsignedBigInteger('card_skill_type_id');
            $table->string('card_skill_element');
            $table->string('card_skill_energy_cost');
            $table->string('card_skill_cooldown');
            $table->string('card_skill_range');
            $table->string('card_skill_description');
            $table->timestamps();


            $table->foreign('card_skill_type_id')->references('id')->on('card_skill_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_skills');
    }
};
