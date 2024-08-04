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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('issue_title');
            $table->bigInteger('volume_id')->unsigned();
            $table->string('issue_image_cover')->nullable();
            $table->longText('issue_description')->nullable();
            $table->boolean('issue_is_adult');
            $table->boolean('issue_is_locked')->nullable();
            $table->integer('issue_number');
            $table->string('issue_slug_name');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
