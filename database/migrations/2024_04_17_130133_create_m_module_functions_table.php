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
        Schema::create('m_module_functions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('module_id');
            $table->foreign('module_id')->references('id')->on('m_modules');
            $table->string('routes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_module_functions');
    }
};
