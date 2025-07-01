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
        Schema::create('training_employee', function (Blueprint $table) {
            $table->id('traiemp')->primary();
            $table->unsignedBigInteger('employe_id');
            $table->foreign('employe_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('training_id');
            $table->foreign('training_id')->references('traini')->on('training')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_employee');
        Schema::table('training_employee', function (Blueprint $table) {
            $table->dropForeign(['employe_id', 'training_id']);
            $table->dropColumn('employe_id');
            $table->dropColumn('training_id');
        });
    }
};
