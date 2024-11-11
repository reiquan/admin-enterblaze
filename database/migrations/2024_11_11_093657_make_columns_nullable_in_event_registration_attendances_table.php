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
        Schema::table('event_registration_attendances', function (Blueprint $table) {
            //
            $table->string('attendee_company_name')->nullable()->change();
            $table->string('attendee_company_description')->nullable()->change();
            $table->string('attendee_company_url')->nullable()->change();
            $table->string('attendee_number_of_employees_attending')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_registration_attendances', function (Blueprint $table) {
            //
            $table->string('attendee_company_name')->nullable(false)->change();
            $table->string('attendee_company_description')->nullable(false)->change();
            $table->string('attendee_company_url')->nullable(false)->change();
            $table->string('attendee_number_of_employees_attending')->nullable(false)->change();
        });
    }
};
