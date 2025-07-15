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
        Schema::create('objectifs', function (Blueprint $table) {
            $table->id('objectif_id')->primary();
            $table->text('objectif');
            $table->tinyInteger('note');
            $table->string('appreciation');
            $table->unsignedBigInteger('id_evaluation');
            $table->foreign('id_evaluation')->references('evaluation_id')->on('evaluations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objectifs');
        Schema::table('objectifs', function (Blueprint $table) {
            $table->dropForeign(['id_evaluation']);
            $table->dropColumn('id_evaluation');
        });
    }
};
