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
        Schema::table('books', function (Blueprint $table) {
            //
            $table->string('book_audience')->after('book_genres');
            $table->string('book_subtitle')->after('book_title');
            $table->string('book_creator')->after('book_description');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            //
            $table->dropColumn('book_audience');
            $table->dropColumn('book_subtitle');
            $table->dropColumn('book_creator');
        });
    }
};
