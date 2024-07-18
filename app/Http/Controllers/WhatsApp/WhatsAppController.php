<?php

namespace App\Http\Controllers\WhatsApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\Student;
use App\Models\PrayerSchedule;
use \DateTime;
use GuzzleHttp\Client;

class WhatsAppController extends Controller
{
    public function index(){

    }

    function convertPhoneNumber($number) {
        // Periksa apakah nomor dimulai dengan '0'
        if (substr($number, 0, 1) == '0') {
            // Ganti '0' di awal nomor dengan '62'
            $number = substr_replace($number, '62', 0, 1);
        }
        
        return $number;
    }

    public function sendMessage(Request $request){
        $request->validate([
            'number' => 'required',
        ]);

        $id = $request->id;
        $studentId = $request->idSiswa;
        $student = Student::where('id', $studentId)->first();
        $attendance = Absence::where('id', $id)
                        ->where('student_id', $studentId)
                        ->first();

        $prayerSchedule = PrayerSchedule::where('id', $attendance->prayer_schedule_id)->first();

        $checkIn = date('H:i:s', strtotime($attendance->check_in));
        $prayerLastTimeSchedule = $prayerSchedule->end_clock;

        $checkInTime = new DateTime($checkIn);
        $prayerEndTime = new DateTime($prayerLastTimeSchedule);

        // Hitung selisih waktu
        $interval = $checkInTime->diff($prayerEndTime);
        // Konversi selisih waktu ke dalam menit
        $minutesLate = ($interval->h * 60) + $interval->i;

        $message = "Yth Bapak/Ibu Siswa {$student->nama_depan} {$student->nama_belakang},\n\n";
        $message .= "Siswa dengan nama *{$student->nama_depan} {$student->nama_belakang}* kelas *{$student->kelas}* terlambat melaksanakan ibadah sholat {$prayerSchedule->sholat}.\n";
        $message .= "Dimohon untuk disiplinkan anak Bapak/Ibu supaya tetap rajin dan tepat waktu ibadah.\n\n";
        $message .= "Terima Kasih";


        $telepon = $this->convertPhoneNumber($request->number);

        $client = new Client();
        $apiUrl = config('services.api.whatsapp_url');
        $response = $client->post($apiUrl.'send-message', [
            'json' => [
                'number' => $telepon,
                'message'=> $message
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);

        if ($response->getStatusCode() === 200) {
            return response()->json([
                'success' => true,
                'message' => $responseBody['message'],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => $responseBody['error'] ?? 'Unknown error',
            ]);
        }
    }
}
