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
        Schema::create('notify_subscribers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('alert_type');
            $table->string('alert_title');
            $table->string('alert_body');
            $table->json('alert_attachments')->nullable();
            $table->dateTimeTz('post_date', $precision = 0);
            $table->timestamps();
            
            $table->softDeletes($column = 'deleted_at', $precision = 0);


         
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notify_subscribers');
    }
};
