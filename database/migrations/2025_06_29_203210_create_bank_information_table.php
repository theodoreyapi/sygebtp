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
        Schema::create('bank_information', function (Blueprint $table) {
            $table->id('bank')->primary();
            $table->string('name_bank');
            $table->string('code_bank');
            $table->string('code_guichet_bank');
            $table->string('number_compte_bank');
            $table->string('cle_rib_bank');
            $table->string('iban_bank');
            $table->string('swift_bank');
            $table->string('statut_bank')->default('Active')->comment('Active, Inactive');
            $table->unsignedBigInteger('employe_id');
            $table->foreign('employe_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_information');
        Schema::table('bank_information', function (Blueprint $table) {
            $table->dropForeign(['employe_id']);
            $table->dropColumn('employe_id');
        });
    }
};
