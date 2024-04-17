<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [ 
                'id'    => 1,
                'role'  => 'Guru' 
            ],
            [
                'id'    => 2, 
                'role'  => 'Guru Scanner' 
            ],
            [
                'id'    => 3, 
                'role'  => 'Siswa' 
            ],
        ]);
    }
}
