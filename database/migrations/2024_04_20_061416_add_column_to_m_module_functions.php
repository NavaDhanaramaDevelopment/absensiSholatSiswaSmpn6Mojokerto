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
        Schema::table('m_module_functions', function (Blueprint $table) {
            $table->string('nama', 64)->after('module_id');
            $table->string('nama_menu', 64)->nullable()->after('nama');
            $table->tinyInteger('is_parent')->after('nama_menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_module_functions', function (Blueprint $table) {
            $table->dropColumn('nama');
            $table->dropColumn('nama_menu');
            $table->dropColumn('is_parent');
        });
    }
};
