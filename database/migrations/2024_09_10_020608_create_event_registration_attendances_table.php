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
        Schema::create('event_registration_attendances', function (Blueprint $table) {
            $table->id();
            //attendee_first_name
            $table->string('attendee_first_name');
            // attendee_last_name
            $table->string('attendee_last_name');
            //attendee_email
            $table->string('attendee_email');
            //attendee_phone_number
            $table->string('attendee_phone_number');
            //attendee_event_registration_id
            $table->unsignedBigInteger('event_registration_id');

            //attendee_company_name
            $table->string('attendee_company_name')->nulable();

            //attendee_company_description
            $table->string('attendee_company_description')->nulable();
            //attendee_company_url
            $table->string('attendee_company_url')->nulable();
            //attendee_number_of_employees_attending
            $table->string('attendee_number_of_employees_attending')->nulable();
            //acknowledgement_of_no_refunds
            $table->string('acknowledgement_of_no_refunds')->nulable();
             //attendee_receipt_number
             $table->string('attendee_receipt_number');

            $table->timestamps();
            //deleted_at
            $table->date('deleted_at')->nullable();
            $table->foreign('event_registration_id')->references('id')->on('event_registrations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registration_attendances');
    }
};
