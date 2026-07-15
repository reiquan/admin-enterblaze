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
        Schema::create('event_livestreams', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('event_id');

            $table->string('event_livestream_platform')
            ->nullable();

            $table->string('event_livestream_title')
                ->nullable();

            $table->string('event_livestream_category_id')
                ->nullable();

            $table->string('event_livestream_schedule_segment_id')
                ->nullable();

            $table->string('event_livestream_status')
                ->nullable();

            $table->timestamp('event_livestream_synced_at')
                ->nullable();

            $table->text('event_livestream_error')
                ->nullable();
                $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->cascadeOnDelete();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_livestreams');
    }
};
