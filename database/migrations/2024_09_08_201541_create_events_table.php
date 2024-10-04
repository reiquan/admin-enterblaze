<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->string('event_promo_image')->nullable();
            $table->longText('event_about');
            $table->unsignedBigInteger('host_user_id');
            $table->string('event_address_line_1');
            $table->string('event_address_line_2')->nullable();
            $table->string('event_city');
            $table->string('event_state');
            $table->string('event_zip');
            $table->datetime('event_start_date');
            $table->datetime('event_end_date');
            $table->json('attendees');
            $table->boolean('is_active');
            $table->json('tags')->nullable();

            $table->timestamps();

            $table->foreign('host_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
