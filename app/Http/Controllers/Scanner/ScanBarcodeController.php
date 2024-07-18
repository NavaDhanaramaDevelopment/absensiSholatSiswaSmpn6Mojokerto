<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Student;
use App\Models\Barcode;
use App\Models\PrayerSchedule;
use Illuminate\Http\Request;

class ScanBarcodeController extends Controller
{
    public function attendanceGuest(Request $request){
        try {
            $barcode = $request->qrCodeMessage;
            $studentId = Student::where('user_id', auth()->user()->id)->first()->id;

            $getBarcodeAbsence = Barcode::where('student_id', $studentId)
                                    ->where('barcode_value', $barcode);
            $checkBarcode = $getBarcodeAbsence->first();
            if($checkBarcode->is_scanned == 0){
                return response()->json([
                    'code'      => 404,
                    'status'    => false,
                    'message'   => 'Anda Sudah Absen!',
                ]);
            }

            $getBarcodeAbsence->update([
                'is_scanned' => 1
            ]);

            $checkInTime = Carbon::now()->format('H:i:s');
            $checkIn = Carbon::now()->format('Y-m-d H:i:s');

            $prayer = PrayerSchedule::whereTime('start_clock', '<=', $checkInTime)
                            ->whereTime('end_clock', '>=', $checkInTime)
                            ->first();

            $absence = Absence::where('barcode_id', $checkBarcode->id)->first();
            if(!$absence){
                $create = new Absence();
                $create->student_id = $studentId;
                $create->prayer_schedule_id = $prayer->id;
                $create->check_in = $checkIn;

                $absenceLate = strtotime('-10 minutes', $prayer->end_clock);

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
            
            return response()->json([
                'code'      => 500,
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
}
