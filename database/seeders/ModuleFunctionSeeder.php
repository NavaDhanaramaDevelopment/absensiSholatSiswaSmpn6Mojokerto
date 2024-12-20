<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_module_functions')->insert([
            
            [
                'id'            => 'D1',
                'module_id'     => 'D',
                'nama'          => 'Dashboard',
                'nama_menu'     => 'Dashboard',
                'routes'        => 'dashboard',
                'is_parent'     => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => '-',
                'module_id'     => '-',
                'nama'          => ' ',
                'nama_menu'     => ' ',
                'routes'        => ' ',
                'is_parent'     => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'MA1',
                'module_id'     => 'M',
                'nama'          => 'View Guru',
                'nama_menu'     => 'Guru',
                'routes'        => 'teacher',
                'is_parent'     => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'MA2',
                'module_id'     => 'M',
                'nama'          => 'Create Guru',
                'nama_menu'     => null,
                'routes'        => 'teacher.store',
                'is_parent'     => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'MA3',
                'module_id'     => 'M',
                'nama'          => 'Update Guru',
                'nama_menu'     => null,
                'routes'        => 'teacher.update',
                'is_parent'     => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'MA4',
                'module_id'     => 'M',
                'nama'          => 'Delete Guru',
                'nama_menu'     => null,
                'routes'        => 'teacher.delete',
                'is_parent'     => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'MB1',
                'module_id'     => 'M',
                'nama'          => 'View Siswa',
                'nama_menu'     => 'Siswa',
                'routes'        => 'student',
                'is_parent'     => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'MB2',
                'module_id'     => 'M',
                'nama'          => 'Create Siswa',
                'nama_menu'     => null,
                'routes'        => 'student.add',
                'is_parent'     => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'MB3',
                'module_id'     => 'M',
                'nama'          => 'Update Siswa',
                'nama_menu'     => null,
                'routes'        => 'student.update',
                'is_parent'     => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'MB4',
                'module_id'     => 'M',
                'nama'          => 'Delete Siswa',
                'nama_menu'     => null,
                'routes'        => 'student.delete',
                'is_parent'     => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'ASA1',
                'module_id'     => 'AS',
                'nama'          => 'View Absensi Siswa',
                'nama_menu'     => 'Absensi Siswa',
                'routes'        => 'attendance',
                'is_parent'     => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'ASA2',
                'module_id'     => 'AS',
                'nama'          => 'Create Absensi Siswa',
                'nama_menu'     => null,
                'routes'        => 'attendance.add',
                'is_parent'     => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'ASA3',
                'module_id'     => 'AS',
                'nama'          => 'Barcode Siswa',
                'nama_menu'     => null,
                'routes'        => 'attendance.barcode',
                'is_parent'     => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'WAA1',
                'module_id'     => 'WA',
                'nama'          => 'Connect Whatsapp',
                'nama_menu'     => 'Whatsapp',
                'routes'        => 'whatsapp',
                'is_parent'     => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'WAA2',
                'module_id'     => 'WA',
                'nama'          => 'Kirim Whatsapp',
                'nama_menu'     => null,
                'routes'        => 'whatsapp.send',
                'is_parent'     => 0,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 'SC1',
                'module_id'     => 'SC',
                'nama'          => 'Scan Barcode',
                'nama_menu'     => 'Scan Absensi',
                'routes'        => 'attendanceScan',
                'is_parent'     => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
    }
}
