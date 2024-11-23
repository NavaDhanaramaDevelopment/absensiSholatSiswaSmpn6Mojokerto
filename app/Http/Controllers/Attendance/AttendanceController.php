<?php

namespace App\Http\Controllers\Attendance;

use App\Exports\AbsenceExport;
use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Kelas;
use App\Models\Barcode;
use App\Models\PrayerSchedule;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(){
        $start_date = date('Y-m-d H:i:s', strtotime('-1 month', strtotime(Carbon::now())));
        $end_date = Carbon::now()->format('Y-m-d H:i:s');
        $kelases = Kelas::all();
        return view('absensi.index', compact([
            'start_date',
            'end_date',
            'kelases'
        ]));
    }

    public function populateData(Request $request){
        try {
            if($request->method() == "POST"){
                $filterAttendance = Absence::select('t_absences.id', 't_absences.check_in', 't_absences.is_late', 't_absences.is_alpha', 's.nisn', DB::raw("CONCAT(nama_depan, ' ', nama_belakang) AS nama_lengkap"), 'jps.sholat', 's.no_telepon', 's.id as idSiswa', 's.kelas')
                                ->join('m_students as s', 's.id', '=', 't_absences.student_id')
                                ->join('m_prayer_schedules as jps', 'jps.id', '=', 't_absences.prayer_schedule_id')
                                ->whereBetween('check_in', [$request->start_date, $request->end_date]);

                if($request->kelas != 'all'){
                    $attendances = $filterAttendance->where('s.kelas', $request->kelas)->get();
                }else{
                    $attendances = $filterAttendance->get();
                }
            }else{
                $attendances = Absence::select('t_absences.id', 't_absences.check_in', 't_absences.is_late', 't_absences.is_alpha', 's.nisn', DB::raw("CONCAT(nama_depan, ' ', nama_belakang) AS nama_lengkap"), 'jps.sholat', 's.no_telepon', 's.id as idSiswa', 's.kelas')
                                ->join('m_students as s', 's.id', '=', 't_absences.student_id')
                                ->join('m_prayer_schedules as jps', 'jps.id', '=', 't_absences.prayer_schedule_id')
                                ->get();
            }

            return response()->json($attendances);
        } catch (\Exception $e) {
            \Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Mendapatkan Data Siswa!',
            ]);
        }
    }

    public function insert(){
        $kelas = Kelas::all();
        $prayerList = PrayerSchedule::all();
        return view('absensi.insert', compact(['kelas', 'prayerList']));
    }

    public function store(Request $request){
        $kelas = $request->kelas;
        $jadwal_sholat = $request->jadwal_sholat;
        $students = $request->students;
        $date_now = Carbon::now()->format('Y-m-d');

        try {
            for($i=0; $i < count($students); $i++){
                $getBarcode = Barcode::where('student_id', $students[$i])->first();

                if(is_null($getBarcode) || $getBarcode->is_scanned == 1){
                    Barcode::insert([
                        'student_id'        => $students[$i],
                        'barcode_value'     => Uuid::uuid4()->toString(),
                        'is_scanned'        => 0,
                        'created_at'              => Carbon::now(),
                        'updated_at'              => Carbon::now()
                    ]);
                    $getNewBarcode = Barcode::where('student_id', $students[$i])->first();

                    Absence::insert([
                        'student_id'            => $students[$i],
                        'prayer_schedule_id'    => $jadwal_sholat,
                        'barcode_id'            => $getNewBarcode->id,
                        'check_in'              => Carbon::now(),
                        'is_late'               => 0,
                        'is_alpha'              => 0,
                        'created_at'              => Carbon::now(),
                        'updated_at'              => Carbon::now()
                    ]);
                }else{
                    $checkAbsence = Absence::where('prayer_schedule_id', $jadwal_sholat)
                            ->where('student_id', $students[$i])
                            ->where('barcode_id', $getBarcode->barcode_value)
                            ->whereDate('check_in', $date_now)
                            ->first();
                    if(!is_null($checkAbsence) && !empty($checkAbsence)){
                        continue;
                    }else{
                        Absence::insert([
                            'student_id'            => $students[$i],
                            'prayer_schedule_id'    => $jadwal_sholat,
                            'barcode_id'            => $getBarcode->id,
                            'check_in'              => Carbon::now(),
                            'is_late'               => 0,
                            'is_alpha'              => 0,
                            'created_at'              => Carbon::now(),
                            'updated_at'              => Carbon::now()
                        ]);
                    }
                }
            }

            Session::put('sweetalert', 'success');
            return redirect()->route('attendance')->with('success', 'Berhasil menambahkan data absensi sholat siswa!');
        } catch (\Exception $e) {
            \Log::info($e);
            Session::put('sweetalert', 'alert');
            return redirect()->back()->with('alert', 'Gagal menambahkan data absensi sholat siswa!');
        }
    }

    public function exportAbsence(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $kelas = $request->input('kelas');


        return Excel::download(new AbsenceExport($startDate, $endDate, $kelas), 'Absensi Siswa Periode '.date('d-m-Y', strtotime($startDate)).' s.d. '.date('d-m-Y', strtotime($endDate)).' .xlsx');
    }
}
