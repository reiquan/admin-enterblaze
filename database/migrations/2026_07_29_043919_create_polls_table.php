<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->id();

            $table->string('question');
            $table->unsignedBigInteger('universe_id')->nullable();
            $table->unsignedBigInteger('book_id')->nullable();
            $table->unsignedBigInteger('issue_id')->nullable();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->unsignedBigInteger('webisode_id')->nullable();
            $table->unsignedBigInteger('webisode_video_id')->nullable();
            $table->unsignedBigInteger('card_series_id')->nullable();
            $table->unsignedBigInteger('card_id')->nullable();
            $table->text('description')->nullable();

            $table->enum('selection_type', [
                'single',
                'multiple',
            ])->default('single');

            $table->unsignedInteger('maximum_selections')
                ->default(1);

            $table->boolean('allow_guests')
                ->default(false);

            $table->boolean('show_results_before_voting')
                ->default(false);

            $table->boolean('show_results_after_voting')
                ->default(true);

            $table->boolean('is_published')
                ->default(false);

            /*
             * Allows a poll to belong to a universe, event,
             * book, card series, webisode, submission, etc.
             */
            $table->nullableMorphs('pollable');

            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index([
                'is_published',
                'starts_at',
                'ends_at',
            ]);

            $table->foreign('event_id')
            ->references('id')
            ->on('events')
            ->cascadeOnDelete();

            $table->foreign('book_id')
            ->references('id')
            ->on('books')
            ->cascadeOnDelete();

            $table->foreign('universe_id')
            ->references('id')
            ->on('universes')
            ->cascadeOnDelete();

            
            $table->foreign('issue_id')
            ->references('id')
            ->on('issues')
            ->cascadeOnDelete();

            
            $table->foreign('card_series_id')
            ->references('id')
            ->on('card_series')
            ->cascadeOnDelete();

            
            $table->foreign('card_id')
            ->references('id')
            ->on('card_series')
            ->cascadeOnDelete();

            
            $table->foreign('webisode_id')
            ->references('id')
            ->on('webisodes')
            ->cascadeOnDelete();

            
            $table->foreign('webisode_video_id')
            ->references('id')
            ->on('webisode_videos')
            ->cascadeOnDelete();

            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('polls');
    }
};