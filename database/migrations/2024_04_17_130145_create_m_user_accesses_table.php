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
        Schema::create('m_user_accesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->references('id')->on('roles');
            $table->string('module_function_id')->nullable();
            $table->foreign('module_function_id')->references('id')->on('m_module_functions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_user_accesses');
    }
};
