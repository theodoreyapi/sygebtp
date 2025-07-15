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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id('leave_id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('leave_type'); // Medical, Casual, Annual...
            $table->date('start_date');
            $table->date('end_date');
            $table->string('day_type')->nullable(); // Full Day, First Half...
            $table->decimal('total_days', 4, 1)->default(0); // 1.0, 0.5, etc.
            $table->decimal('remaining_days', 4, 1)->default(0);
            $table->text('reason')->nullable();
            $table->text('justification')->nullable(); // info bulle
            $table->enum('status', ['New', 'Approved', 'Declined'])->default('New');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropForeign(['user_id', 'approved_by']);
            $table->dropColumn('user_id');
            $table->dropColumn('approved_by');
        });
    }
};
