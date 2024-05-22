<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class BarcodeStudent extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_barcodes')->insert([
            [
                'student_id'        => 1,
                'barcode_value'     => Uuid::uuid4()->getHex(),
                'is_scanned'        => 0,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ],
        ]);
    }
}
