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
        Schema::create('universe_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('universe_id');
            $table->string('subscription_type');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('universe_id')->references('id')->on('universes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universe_subscriptions');
    }
};
