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
        Schema::create('training', function (Blueprint $table) {
            $table->id('traini')->primary();
            $table->integer('cost_traini');
            $table->string('start_traini');
            $table->string('end_traini');
            $table->longText('description_traini');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('trai_type')->on('training_type');
            $table->unsignedBigInteger('trainer_id');
            $table->foreign('trainer_id')->references('trai')->on('trainers');
            $table->string('status_traini', 20)->comment('Active, inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training');
        Schema::table('training', function (Blueprint $table) {
            $table->dropForeign(['employe_id', 'type_id', 'trainer_id']);
            $table->dropColumn('employe_id');
            $table->dropColumn('type_id');
            $table->dropColumn('trainer_id');
        });
    }
};
