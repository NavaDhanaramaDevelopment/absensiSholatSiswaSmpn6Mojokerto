<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index(){
        return view('scan.index');
    }

    public function getDataScanAbsensi(Request $request){
        try {
            //code...
        }  catch (\Exception $th) {
            return response()->json([
                'code'    => 500,
                'message'   => 'Something Error! Please Contact Developer!',
                'error'     => $th
            ]);
        }
    }
}
