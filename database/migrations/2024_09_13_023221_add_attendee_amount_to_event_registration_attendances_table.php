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
            $table->decimal('attendee_charge', 8, 2)->after('attendee_receipt_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_registration_attendances', function (Blueprint $table) {
            //
            $table->dropColumn('attendee_charge');
        });
    }
};
