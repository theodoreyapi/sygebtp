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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('att_id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('date');
            $table->timestamp('punch_in_time')->nullable();
            $table->timestamp('punch_out_time')->nullable();
            $table->float('worked_hours')->default(0);
            $table->float('break_minutes')->default(0);
            $table->float('productive_hours')->default(0);
            $table->float('overtime_hours')->default(0);
            $table->enum('status', ['Present', 'Absent', 'Late', 'On Leave'])->default('Present');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
