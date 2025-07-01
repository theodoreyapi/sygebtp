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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id('promo')->primary();
            $table->string('date_promo');
            $table->unsignedBigInteger('employe_id')->nullable();
            $table->foreign('employe_id')->references('id')->on('users');
            $table->unsignedBigInteger('promo_from')->nullable();
            $table->foreign('promo_from')->references('design')->on('designations');
            $table->unsignedBigInteger('promo_to')->nullable();
            $table->foreign('promo_to')->references('design')->on('designations');
            $table->string('status_promo', 20)->comment('Active, inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropForeign(['employe_id', 'promo_from', 'promo_to']);
            $table->dropColumn('employe_id');
            $table->dropColumn('promo_from');
            $table->dropColumn('promo_to');
        });
    }
};
