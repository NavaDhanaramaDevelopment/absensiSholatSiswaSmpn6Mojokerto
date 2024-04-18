<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_teachers')->insert([
            [
                'user_id'       => 1,
                'kode_guru'     => '2022',
                'nama_depan'    => 'depan',
                'nama_belakang' => 'belakang',
                'jenis_kelamin' => 'Laki-Laki',
                'no_telepon'    => '0812048213',
                'wali_kelas'    => 'A1',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]
        ]);
    }
}
