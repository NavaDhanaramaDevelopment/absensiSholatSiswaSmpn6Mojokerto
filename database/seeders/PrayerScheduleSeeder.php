<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrayerScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_prayer_schedules')->insert([
            [
                'sholat'        => 'Zuhur',
                'start_clock'   => '11:27:00',
                'end_clock'     => '14:42:00',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now() 
            ],
            [
                'sholat'        => 'Ashar',
                'start_clock'   => '14:48:00',
                'end_clock'     => '17:10:00',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now() 
            ],
        ]);
    }
}
