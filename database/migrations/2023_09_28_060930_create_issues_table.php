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
            $table->bigInteger('volume_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('image_cover');
            $table->longText('description')->nullable();
            $table->boolean('is_adult');
            $table->boolean('is_locked');
            $table->integer('issue_number');
            $table->string('slug_name');
            $table->timestamps();
            $table->foreign('volume_id')->references('id')->on('volumes');
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
