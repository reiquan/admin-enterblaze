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
            $table->string('attendee_method_id')->nullable();
            $table->string('attendee_intent_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_registration_attendances', function (Blueprint $table) {
            //
            $table->dropColumn('attendee_method_id');
            $table->dropColumn('attendee_intent_id');
        });
    }
};
