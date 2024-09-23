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

        $api_key   = 'e7b82e6e0668b27b30ac626ed95be856f88ce34a';
        $id_device = '12345';
        $url   = 'https://api.watsap.id/send-message';
        $no_hp = $telepon;
        $pesan = $message;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0); // batas waktu response
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POST, 1);

        $data_post = [
        'id_device' => $id_device,
        'api-key' => $api_key,
        'no_hp'   => $no_hp,
        'pesan'   => $pesan
        ];
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_post));
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($curl);
        curl_close($curl);

        dd($response);

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
