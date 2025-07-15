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
        Schema::create('asso_type_training', function (Blueprint $table) {
            $table->id('asso_type_training_id')->primary();
            $table->unsignedBigInteger('employe_id');
            $table->foreign('employe_id')->references('id')->on('users');
            $table->unsignedBigInteger('formation_id');
            $table->foreign('formation_id')->references('traini')->on('training')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asso_type_training');
        Schema::table('asso_type_training', function (Blueprint $table) {
            $table->dropForeign(['employe_id', 'formation_id']);
            $table->dropColumn('employe_id');
            $table->dropColumn('formation_id');
        });
    }
};
