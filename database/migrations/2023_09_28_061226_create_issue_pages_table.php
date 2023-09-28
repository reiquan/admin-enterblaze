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
        Schema::create('issue_pages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('issue_id')->unsigned();
            $table->string('panel_url');
            $table->boolean('is_adult');
            $table->boolean('is_locked');
            $table->timestamps();

            $table->foreign('issue_id')->references('id')->on('issues');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_pages');
    }
};
