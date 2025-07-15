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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id('evaluation_id')->primary();
            $table->float('note_moyenne');
            $table->string('date_evaluation');
            $table->string('periode_debut');
            $table->string('periode_fin');
            $table->text('commentaire')->nullable();
            $table->unsignedBigInteger('employe_id');
            $table->foreign('employe_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('evaluateur_id');
            $table->foreign('evaluateur_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropForeign(['employe_id', 'evaluateur_id']);
            $table->dropColumn('employe_id');
            $table->dropColumn('evaluateur_id');
        });
    }
};
