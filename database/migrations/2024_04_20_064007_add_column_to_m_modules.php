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
        Schema::table('m_modules', function (Blueprint $table) {
            $table->string('icon', 64)->nullable()->after('is_show');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_modules', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
