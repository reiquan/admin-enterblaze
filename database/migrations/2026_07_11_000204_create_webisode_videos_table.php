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
        Schema::create('webisode_videos', function (Blueprint $table) {
            $table->id();
        
            // Parent webisode
            $table->foreignId('webisode_id')
                ->constrained('webisodes')
                ->cascadeOnDelete();
        
            // Video information
            $table->string('video_title');
            $table->string('video_slug');
            $table->text('video_description')->nullable();
        
            // Ordering
            $table->unsignedInteger('video_number')->default(1);
            $table->unsignedInteger('video_sort_order')->default(0);
        
            // Video files
            $table->string('video_path')->nullable();
            $table->string('video_thumbnail')->nullable();
            $table->string('video_trailer_path')->nullable();
        
            // File metadata
            $table->string('video_mime_type')->nullable();
            $table->unsignedBigInteger('video_file_size')->nullable();
            $table->unsignedInteger('video_duration_seconds')->nullable();
        
            // Publishing
            $table->boolean('video_is_published')->default(false);
            $table->boolean('video_is_featured')->default(false);
            $table->boolean('video_is_locked')->default(false);
            $table->timestamp('video_publish_at')->nullable();
        
            // Access and pricing
            $table->boolean('video_is_free')->default(true);
            $table->unsignedInteger('video_blaze_token_cost')->default(0);
            $table->decimal('video_price', 10, 2)->nullable();
        
            // Content settings
            $table->string('video_rating')->nullable();
            $table->boolean('video_is_adult')->default(false);
            $table->json('video_tags')->nullable();
        
            // Analytics
            $table->unsignedBigInteger('video_view_count')->default(0);
            $table->unsignedBigInteger('video_like_count')->default(0);
            $table->unsignedBigInteger('video_comment_count')->default(0);
        
            // Optional external hosting
            $table->string('video_provider')->nullable();
            $table->string('video_external_id')->nullable();
            $table->text('video_embed_url')->nullable();
        
            $table->timestamps();
            $table->softDeletes();
        
            $table->unique(['webisode_id', 'video_slug']);
            $table->index(['webisode_id', 'video_sort_order']);
            $table->index(['video_is_published', 'video_publish_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webisode_videos');
    }
};
