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
        Schema::table('volumes', function (Blueprint $table) {
            //
            $table->string('volume_name')->after('id');
            $table->integer('volume_number')->after('volume_name');
            $table->unsignedBigInteger('book_id')->after('volume_number');
            $table->longText('description')->after('book_id');
            $table->boolean('is_adult')->after('description');
            $table->string('is_locked')->after('is_adult');
            $table->string('image_cover')->after('is_locked');
            $table->integer('votes')->after('image_cover');
            $table->softDeletes($column = 'deleted_at', $precision = 0)->after('updated_at');

            $table->foreign('book_id')->references('id')->on('books');
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('volumes', function (Blueprint $table) {
            //
            $table->dropColumn('volume_name');
            $table->dropColumn('volume_number');
            $table->dropColumn('book_id');
            $table->dropColumn('description');
            $table->dropColumn('is_adult');
            $table->dropColumn('is_locked');
            $table->dropColumn('image_cover');
            $table->dropColumn('votes');

        });
    }
};
