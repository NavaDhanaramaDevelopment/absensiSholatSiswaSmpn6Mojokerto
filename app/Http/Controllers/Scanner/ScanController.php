<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absence;
use DB;

class ScanController extends Controller
{
    public function index(){
        return view('scan.index');
    }

    public function getDataScanAbsensi(Request $request){
        try {
            $dateNow = date('Y-m-d');
            $absences = Absence::select('t_absences.id', 't_absences.check_in', 't_absences.is_late', 't_absences.is_alpha', 's.nisn', DB::raw("CONCAT(nama_depan, ' ', nama_belakang) AS nama_lengkap"), 'jps.sholat', 's.no_telepon', 's.id as idSiswa', 's.kelas')
                                ->join('m_students as s', 's.id', '=', 't_absences.student_id')
                                ->join('m_prayer_schedules as jps', 'jps.id', '=', 't_absences.prayer_schedule_id')
                                ->whereBetween('check_in', ["$dateNow 00:00:00", "$dateNow 23:59:59"])
                                ->get();

            return response()->json($absences);
        }  catch (\Exception $th) {
            return response()->json([
                'code'    => 500,
                'message'   => 'Something Error! Please Contact Developer!',
                'error'     => $th
            ]);
        }
    }
}
