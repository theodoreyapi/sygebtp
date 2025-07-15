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
        Schema::create('incendits', function (Blueprint $table) {
            $table->id('incendit_id')->primary();
            $table->string('reference_incendit');
            $table->string('type_incendit')->comment('Incident, Accident');
            $table->string('lieu_incendit');
            $table->string('gravite_incendit')->comment('Mineur, Majeur, Critique');
            $table->string('date_incendit');
            $table->string('description_incendit');
            $table->string('statut_incendit')->comment('Traite, Encours, Refuse');
            $table->unsignedBigInteger('employe_id');
            $table->foreign('employe_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('emetteur_id');
            $table->foreign('emetteur_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incendits');
        Schema::table('incendits', function (Blueprint $table) {
            $table->dropForeign(['employe_id', 'emetteur_id']);
            $table->dropColumn('employe_id');
            $table->dropColumn('emetteur_id');
        });
    }
};
