<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_modules')->insert([
            [
                'id'            => '-',
                'module'        => '-',
                'is_show'       => 0,
                'icon'          => ' ',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'D',
                'module'        => 'Dashboard',
                'is_show'       => 1,
                'icon'          => 'mdi mdi-file-document-box menu-icon',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'M',
                'module'        => 'Master',
                'is_show'       => 1,
                'icon'          => 'mdi mdi-view-dashboard',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'AS',
                'module'        => 'Absensi Siswa',
                'is_show'       => 1,
                'icon'          => 'mdi mdi-fingerprint',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'WA',
                'module'        => 'Whatsapp',
                'is_show'       => 1,
                'icon'          => 'mdi mdi-whatsapp',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'SC',
                'module'        => 'Scan Siswa',
                'is_show'       => 1,
                'icon'          => 'mdi mdi-barcode-scan',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
    }
}
