<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $sql = "
            CREATE PROCEDURE generate_menu(
                IN p_role_id BIGINT(20) UNSIGNED
            )
            BEGIN
                SELECT
                    m_modules.id AS module_id,
                    m_modules.module AS module_name,
                    m_modules.is_show AS is_main_menu,
                    m_modules.icon AS main_menu_icon,
                    m_module_functions.id AS function_id,
                    m_module_functions.nama AS function_name,
                    m_module_functions.nama_menu AS function_menu
                FROM
                    m_modules
                LEFT JOIN
                    m_module_functions ON m_modules.id = m_module_functions.module_id
                LEFT JOIN
                    m_user_accesses ON m_module_functions.id = m_user_accesses.module_function_id
                WHERE
                    m_user_accesses.role_id = p_role_id OR m_modules.id IN (
                        SELECT DISTINCT module_id
                        FROM m_user_accesses
                        WHERE role_id = p_role_id
                    );
            END;
        ";

        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS generate_menu;');
    }
};
