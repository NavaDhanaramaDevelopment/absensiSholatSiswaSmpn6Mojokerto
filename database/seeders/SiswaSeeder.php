<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_students')->insert([
            [
                'user_id'       => 3,
                'nisn'          => 2024,
                'nama_depan'    => 'ini',
                'nama_belakang' => 'siswa',
                'kelas'         => '7A',
                'jenis_kelamin' => 'Laki-Laki',
                'no_telepon'    => '081728361827',
                'alamat'        => 'Ini Alamat Siswa',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]
        ]);
    }
}
