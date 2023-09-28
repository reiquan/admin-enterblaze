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
        Schema::create('volumes', function (Blueprint $table) {
            $table->id();
            $table->string('volume_name');
            $table->integer('volume_number');
            $table->bigInteger('book_id')->unsigned()->nullable();
            $table->mediumText('description');
            $table->boolean('is_locked');
            $table->boolean('is_adult');
            $table->string('image_cover');
            $table->integer('votes');


            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volumes');
    }
};
