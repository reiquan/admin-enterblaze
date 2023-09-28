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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->json('genres')->nullable();
            $table->mediumText('description');
            $table->string('image_path');
            $table->string('slug_name');
            $table->unsignedBigInteger('universe_id')->nullable();
            $table->string('book_type');
            $table->date('published_at');
            $table->timestamps();

            $table->foreign('universe_id')->references('id')->on('universes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
