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
        Schema::create('universes', function (Blueprint $table) {
            $table->id();
            $table->string('universe_name')->nullable();
            $table->string('universe_description')->nullable();
            $table->string('universe_audience')->nullable();
            $table->string('universe_image_url')->nullable();
            $table->string('universe_logo')->nullable();
            $table->string('universe_slug_name')->nullable();
            $table->unsignedBigInteger('universe_user_id')->nullable();
            $table->boolean('universe_is_active')->nullable();
           


            $table->foreign('universe_user_id')->references('id')->on('users');
 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universes');
    }
};