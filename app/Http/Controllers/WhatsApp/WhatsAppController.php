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

        $api_key   = '4xBdzGxwAHsJmVyYvYw8OWikiWVZZyWoxy7u3PgrUZhNz5tdAc';
        $id_device = '9528';
        $url   = 'https://api.watsap.id/send-message';
        $no_hp = $telepon;
        $pesan = $message;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.wapanels.com/api/create-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'appkey' => '7dba4d3f-f622-4ed2-9ccc-27817f0fbe84',
                'authkey' => '4xBdzGxwAHsJmVyYvYw8OWikiWVZZyWoxy7u3PgrUZhNz5tdAc',
                'to' => $no_hp,
                'message' => $pesan,
                'sandbox' => 'false'
            ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);

        $responseData = json_decode($response);

        if (isset($responseData->message_status) && $responseData->message_status == 'Success') {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengirim pesan ke '.$student->nama_depan.' '.$student->nama_belakang.'!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Gagal mengirim pesan ke '.$student->nama_depan.' '.$student->nama_belakang.'!',
            ]);
        }
    }
}
