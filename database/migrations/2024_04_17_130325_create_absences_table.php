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
        Schema::create('t_absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')->on('m_students');
            $table->foreignId('prayer_schedule_id')->references('id')->on('m_prayer_schedules');
            $table->foreignId('barcode_id')->references('id')->on('t_barcodes');
            $table->timestamp('check_in');
            $table->boolean('is_late')->nullable();
            $table->boolean('is_alpha')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
