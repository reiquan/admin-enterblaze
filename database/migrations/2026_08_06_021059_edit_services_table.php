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
        //
        Schema::table('services', function (Blueprint $table) {
            // Change the column from string to longText
            $table->longText('service_description')->change();
        });
      

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('your_table_name', function (Blueprint $table) {
            $table->string('service_description')->change(); 
        });
    }
};
