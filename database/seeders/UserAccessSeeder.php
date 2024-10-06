<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_user_accesses')->insert([
            [
                'role_id'               => 1,
                'module_id'             => 'M',
                'module_function_id'    => 'C1',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'M',
                'module_function_id'    => 'C2',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'M',
                'module_function_id'    => 'C3',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'M',
                'module_function_id'    => 'C4',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'D',
                'module_function_id'    => '-',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'M',
                'module_function_id'    => '-',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'AS',
                'module_function_id'    => '-',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'WA',
                'module_function_id'    => '-',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'M',
                'module_function_id'    => 'MA1',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'M',
                'module_function_id'    => 'MA2',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'M',
                'module_function_id'    => 'MA3',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'M',
                'module_function_id'    => 'MA4',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'M',
                'module_function_id'    => 'MB1',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'M',
                'module_function_id'    => 'MB2',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'M',
                'module_function_id'    => 'MB3',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'M',
                'module_function_id'    => 'MB4',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'AS',
                'module_function_id'    => 'ASA1',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'AS',
                'module_function_id'    => 'ASA2',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'AS',
                'module_function_id'    => 'ASA3',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'WA',
                'module_function_id'    => 'WAA1',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 1,
                'module_id'             => 'WA',
                'module_function_id'    => 'WAA2',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 2,
                'module_id'             => 'D',
                'module_function_id'    => '-',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 2,
                'module_id'             => 'SC',
                'module_function_id'    => '-',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 2,
                'module_id'             => 'SC',
                'module_function_id'    => 'SC1',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 4,
                'module_id'             => 'D',
                'module_function_id'    => '-',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 4,
                'module_id'             => 'M',
                'module_function_id'    => '-',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 4,
                'module_id'             => 'AS',
                'module_function_id'    => '-',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 4,
                'module_id'             => 'WA',
                'module_function_id'    => '-',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 4,
                'module_id'             => 'M',
                'module_function_id'    => 'MA1',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 4,
                'module_id'             => 'M',
                'module_function_id'    => 'MB1',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 4,
                'module_id'             => 'AS',
                'module_function_id'    => 'ASA1',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 4,
                'module_id'             => 'AS',
                'module_function_id'    => 'ASA2',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 4,
                'module_id'             => 'AS',
                'module_function_id'    => 'ASA3',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 4,
                'module_id'             => 'WA',
                'module_function_id'    => 'WAA1',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
            [
                'role_id'               => 4,
                'module_id'             => 'WA',
                'module_function_id'    => 'WAA2',
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ],
        ]);
    }
}
