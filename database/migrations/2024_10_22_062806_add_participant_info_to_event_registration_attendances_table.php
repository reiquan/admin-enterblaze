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
            $table->string('attendee_handle_type')->nullable()->after('attendee_email');
            $table->string('attendee_handle_name')->nullable()->after('attendee_handle_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_registration_attendances', function (Blueprint $table) {
            //
        });
    }
};
