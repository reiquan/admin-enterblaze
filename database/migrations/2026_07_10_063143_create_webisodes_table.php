<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webisodes', function (Blueprint $table) {

            $table->id();

            // Ownership
            $table->unsignedBigInteger('webisode_universe_id');

            // Basic Info
            $table->string('webisode_title');
            $table->string('webisode_slug')->nullable();
            $table->string('webisode_logline')->nullable();

            $table->text('webisode_description')->nullable();
            $table->text('webisode_status')->nullable();

            // Media
            $table->string('webisode_cover_image')->nullable();
            


            // Publishing
            $table->boolean('webisode_is_active')->default(false);
            $table->boolean('webisode_is_featured')->default(false);
            $table->boolean('webisode_is_adult')->default(false);

            // Discovery
            $table->json('webisode_tags')->nullable();
            $table->string('webisode_genre')->nullable();
            $table->string('webisode_rating')->nullable();
            $table->string('webisode_release_date')->nullable();

            // Monetization
            $table->decimal('webisode_price', 10, 2)->nullable();

            // Stats
            $table->unsignedInteger('webisode_episode_count')->default(0);
            $table->unsignedBigInteger('webisode_view_count')->default(0);
            $table->unsignedBigInteger('webisode_subscriber_count')->default(0);


            $table->timestamps();
            $table->softDeletes();

            $table->foreign('webisode_universe_id')
                ->references('id')
                ->on('universes')
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webisodes');
    }
};
