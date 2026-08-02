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
        Schema::create('services', function (Blueprint $table) {

            $table->id();
            $table->string('service_name');
            $table->string('service_description');
            $table->string('service_price');
            $table->string('service_is_active');
            $table->string('service_frequency');
            $table->string('service_tag');
            $table->string('service_perks');
            $table->string('service_featured');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
