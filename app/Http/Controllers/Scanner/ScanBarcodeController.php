<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Student;
use App\Models\Barcode;
use App\Models\PrayerSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScanBarcodeController extends Controller
{
    public function attendanceGuest(Request $request){
        try {
            $barcode = $request->qrCodeMessage;
            \Log::info($barcode);
            $studentId = Barcode::where('barcode_value', $barcode)->first()->student_id;

            $getBarcodeAbsence = Barcode::where('student_id', $studentId)
                                        ->where('barcode_value', $barcode);
            $checkBarcode = $getBarcodeAbsence->first();
            if($checkBarcode->is_scanned != 0){
                return response()->json([
                    'code'      => 419,
                    'status'    => false,
                    'message'   => 'Anda Sudah Absen!',
                ]);
            }

            $checkInTime = Carbon::now()->format('H:i:s');
            $checkIn = Carbon::now()->format('Y-m-d H:i:s');

            $prayer = PrayerSchedule::whereTime('start_clock', '<=', $checkInTime)
                            ->whereTime('end_clock', '>=', $checkInTime)
                            ->first();

            if(!$prayer){
                return response()->json([
                    'code'      => 419,
                    'status'    => false,
                    'message'   => 'Tidak Ada Jadwal Sholat Di Database!',
                ]);
            }            

            \Log::info($prayer);
            \Log::info($checkIn);

            $absence = Absence::where('barcode_id', $checkBarcode->id)->first();
            if(!$absence){
                $create = new Absence();
                $create->student_id = $studentId;
                $create->prayer_schedule_id = $prayer->id;
                $create->barcode_id = $checkBarcode->id;
                $create->check_in = $checkIn;

                $absenceLate = Carbon::createFromFormat('H:i:s', $prayer->end_clock)->subMinutes(10)->format('H:i:s');

                if($checkInTime > $absenceLate){
                    $create->is_late = 1;
                }else{
                    $create->is_late = 0;
                }

                $create->is_alpha = 0;
                $create->save();
            }else{
                return response()->json([
                    'code'      => 404,
                    'status'    => false,
                    'message'   => 'Anda Sudah Absen!',
                ]);
            }

            $getBarcodeAbsence->update([
                'is_scanned' => 1
            ]);

            return response()->json([
                'code'      => 200,
                'status'    => true,
                'message'   => 'Anda Selesai Absen Sholat '.$prayer->sholat.' !',
            ]);

        }  catch (\Exception $th) {
            return response()->json([
                'code'    => 500,
                'message'   => 'Something Error! Please Contact Developer!',
                'error'     => $th
            ]);
        }
    }

    public function indexData(){
        $dateNow = Carbon::now()->format('Y-m-d');
        $data = Absence::join('m_students', 'm_students.id', '=', 't_absences.student_id')
                    ->select(DB::raw("CONCAT(m_students.nama_depan, ' ', m_students.nama_belakang) AS nama_lengkap"), 'nisn', DB::raw("TIME_FORMAT(t_absences.created_at, '%H:%i:%s') as time_in"), DB::raw("DATE_FORMAT(t_absences.created_at, '%d %M %Y') as date_attendance"))
                    ->whereBetween('t_absences.created_at', [$dateNow.' 00:00:00', $dateNow.' 23:59:59'])
                    ->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
