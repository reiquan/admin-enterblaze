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
        Schema::create('contest_submissions', function (Blueprint $table) {

            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('submission_title');
            $table->text('submission_description')->nullable();
            $table->string('submission_category')->nullable();

            $table->string('submission_thumbnail')->nullable();
            $table->string('submission_file')->nullable();
            $table->string('submission_url')->nullable();

            $table->string('submission_status')->default('draft');

            $table->boolean('rules_accepted')->default(false);
            $table->boolean('original_work_confirmed')->default(false);
            $table->boolean('public_display_permission')->default(false);

            $table->timestamp('submitted_at')->nullable();

            $table->text('review_notes')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamps();
            $table->softDeletes();
  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_submissions');
    }
};
