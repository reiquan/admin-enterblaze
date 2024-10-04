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
        Schema::create('volumes', function (Blueprint $table) {
            $table->id();
            $table->string('volume_name');
            $table->integer('volume_number');
            $table->bigInteger('volume_book_id')->unsigned()->nullable();
            $table->mediumText('volume_description');
            $table->boolean('volume_is_locked');
            $table->boolean('volume_is_adult');
            $table->string('volume_image_cover');
            $table->integer('volume_votes');
            $table->boolean('volume_is_active');

            $table->timestamps();
            // $table->softDeletes($column = 'deleted_at', $precision = 0)->after('updated_at');
            $table->foreign('volume_book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volumes');
    }
};
