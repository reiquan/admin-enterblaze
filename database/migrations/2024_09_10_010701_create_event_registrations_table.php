<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            //registration_name
            $table->string('registration_name');
            //registration_type
            $table->string('registration_type');
            //registration_description
            $table->string('registration_description');
            //registration start_date
            $table->date('registration_start_date');
            //registration_end_date
            $table->date('registration_end_date');
            //registration_fee
            $table->integer('registration_fee');
            //registration_event_id
            $table->unsignedBigInteger('registration_event_id');
            $table->timestamps();
            //deleted_at
            $table->date('deleted_at');

            $table->foreign('registration_event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations_tabe');
    }
};
