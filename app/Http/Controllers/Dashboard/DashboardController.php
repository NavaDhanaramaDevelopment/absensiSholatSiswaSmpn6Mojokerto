<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Barcode;
use Ramsey\Uuid\Uuid;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        if(Auth()->user()->role_id != 3){
            return view('dashboard.index');
        }else{
            $siswa = Student::where('user_id', Auth()->user()->id)->first();
            $barcodeData = Barcode::where('student_id', $siswa->id)
                            ->where('is_scanned', 0)
                            ->first();
            
            if(!$barcodeData){
                $barcodeData = new Barcode();
                $barcodeData->student_id = $siswa->id;
                $barcodeData->barcode_value = $uuid = Uuid::uuid4()->toString();
                $barcodeData->is_scanned = 0;
                $barcodeData->save();
            }

            $barcode = QrCode::size(512)
                ->format('png')
                ->errorCorrection('M')
                ->generate($barcodeData->barcode_value);
            return view('dashboard.siswa', compact(['siswa', 'barcode']));
        }
    }
}
