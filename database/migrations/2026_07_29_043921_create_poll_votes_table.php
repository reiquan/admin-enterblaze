<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poll_votes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('poll_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('poll_option_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->uuid('guest_identifier')->nullable();

            $table->string('ip_hash', 64)->nullable();
            $table->string('user_agent_hash', 64)->nullable();

            $table->timestamps();

            $table->index([
                'poll_id',
                'user_id',
            ]);

            $table->index([
                'poll_id',
                'guest_identifier',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poll_votes');
    }
};