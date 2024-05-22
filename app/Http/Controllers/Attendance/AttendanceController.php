<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(){
        return view('absensi.index');
    }

    public function populateData(Request $request){
        try {
            $attendances = Absence::select('t_absences.check_in', 't_absences.is_late', 't_absences.is_alpha', 's.nisn', DB::raw("CONCAT(nama_depan, ' ', nama_belakang) AS nama_lengkap"), 'jps.sholat')
                            ->join('m_students as s', 's.id', '=', 't_absences.student_id')
                            ->join('m_prayer_schedules as jps', 'jps.id', '=', 't_absences.prayer_schedule_id')
                            ->get();

            return response()->json($attendances);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Mendapatkan Data Siswa!',
            ]);
        }
    }
}
