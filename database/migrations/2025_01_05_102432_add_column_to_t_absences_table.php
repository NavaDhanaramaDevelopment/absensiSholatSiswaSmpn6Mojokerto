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
        Schema::table('t_absences', function (Blueprint $table) {
            $table->boolean('is_prevented')->nullable()->after('is_alpha');
            $table->boolean('is_shalat')->nullable()->after('is_prevented');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_absences', function (Blueprint $table) {
            $table->dropColumn('is_prevented');
            $table->dropColumn('is_shalat');
        });
    }
};
