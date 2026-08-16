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
        Schema::table('services', function (Blueprint $table) {
            //
            $table->string('service_category')->nullable()->after('service_name');
            $table->boolean('service_is_on_sale')->nullable()->after('service_category');
            $table->integer('service_sale_percentage')->nullable()->after('service_is_on_sale');
            $table->date('service_sale_ends_at')->nullable()->after('service_sale_percentage');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            //
            $table->dropColumn('service_category');
            $table->dropColumn('service_is_on_sale');
            $table->dropColumn('service_sale_percentage');
            $table->dropColumn('service_sale_ends_at');
        });
    }
};
