<?php

namespace App\Http\Controllers\Attendance;

use App\Exports\AbsenceExport;
use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(){
        $start_date = date('Y-m-d H:i:s', strtotime('-1 month', strtotime(Carbon::now())));
        $end_date = Carbon::now()->format('Y-m-d H:i:s');
        return view('absensi.index', compact([
            'start_date',
            'end_date'
        ]));
    }

    public function populateData(Request $request){
        try {
            if($request->method() == "POST"){
                $attendances = Absence::select('t_absences.id', 't_absences.check_in', 't_absences.is_late', 't_absences.is_alpha', 's.nisn', DB::raw("CONCAT(nama_depan, ' ', nama_belakang) AS nama_lengkap"), 'jps.sholat', 's.no_telepon', 's.id as idSiswa', 's.kelas')
                                ->join('m_students as s', 's.id', '=', 't_absences.student_id')
                                ->join('m_prayer_schedules as jps', 'jps.id', '=', 't_absences.prayer_schedule_id')
                                ->whereBetween('check_in', [$request->start_date, $request->end_date])
                                ->get();
            }else{
                $attendances = Absence::select('t_absences.id', 't_absences.check_in', 't_absences.is_late', 't_absences.is_alpha', 's.nisn', DB::raw("CONCAT(nama_depan, ' ', nama_belakang) AS nama_lengkap"), 'jps.sholat', 's.no_telepon', 's.id as idSiswa', 's.kelas')
                                ->join('m_students as s', 's.id', '=', 't_absences.student_id')
                                ->join('m_prayer_schedules as jps', 'jps.id', '=', 't_absences.prayer_schedule_id')
                                ->get();
            }

            return response()->json($attendances);
        } catch (\Exception $e) {
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Mendapatkan Data Siswa!',
            ]);
        }
    }

    public function exportAbsence(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return Excel::download(new AbsenceExport($startDate, $endDate), 'Absensi Siswa.xlsx');
    }
}
