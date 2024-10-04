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
            $table->text('book_title');
            $table->json('book_genres')->nullable();
            $table->mediumText('book_description');
            $table->string('book_audience');
            $table->string('book_subtitle');
            $table->string('book_creator');
            $table->string('book_image_path')->nullable();
            $table->string('book_slug_name')->nullable();
            $table->unsignedBigInteger('book_universe_id')->nullable();
            $table->string('book_type');
            $table->date('book_published_at')->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamps();

            $table->foreign('book_universe_id')->references('id')->on('universes');
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