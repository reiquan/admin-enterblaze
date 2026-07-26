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
        Schema::create('contest_submission_files', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('contest_submission_id')
                ->constrained()
                ->cascadeOnDelete();
        
            $table->string('file_type')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
        
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_submissions_files');
    }
};
