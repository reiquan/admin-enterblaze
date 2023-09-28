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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image_path');
            $table->boolean('is_adult');
            $table->bigInteger('book_id')->unsigned()->nullable();
            $table->bigInteger('volume_id')->unsigned()->nullable();
            $table->bigInteger('issue_id')->unsigned()->nullable();
            $table->unsignedBigInteger('universe_id')->nullable();
            $table->timestamps();
            
            $table->foreign('universe_id')->references('id')->on('universes');
            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('volume_id')->references('id')->on('volumes');
            $table->foreign('issue_id')->references('id')->on('issues');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
