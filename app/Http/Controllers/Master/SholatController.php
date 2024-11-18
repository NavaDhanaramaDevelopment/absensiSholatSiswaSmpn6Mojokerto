<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrayerSchedule;
use DB;

class SholatController extends Controller
{
    public function index(){
        return view('master.sholat.index');
    }

    public function populateData(Request $request){
        try {
            $sholat = PrayerSchedule::all();

            return response()->json($sholat);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Mendapatkan Data Siswa!',
            ]);
        }
    }

    public function add(){
        return view('master.sholat.add');
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
                PrayerSchedule::create([
                    'sholat'        => $request->sholat,
                    'start_clock'   => $request->start_clock,
                    'end_clock'     => $request->end_clock
                ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sukses Menambahkan data Sholat!'
            ]);
        }catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Menambahkan Data Sholat!',
            ]);
        }
    }

    public function edit($id){
        $sholat = PrayerSchedule::where('id', $id)->first();

        return view('master.sholat.add', [
            'sholat' => $sholat,
            'id'      => $id
        ]);
    }

    public function update(Request $request, $id){
        try {
            DB::beginTransaction();
                PrayerSchedule::where('id', $id)->update([
                    'sholat'        => $request->sholat,
                    'start_clock'   => $request->start_clock,
                    'end_clock'     => $request->end_clock
                ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sukses Mengubah data Sholat!'
            ]);
        }catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Mengubah Data Sholat!',
            ]);
        }
    }

    public function destroy($id){
        try {
            $sholat = PrayerSchedule::where('id', $id)->first();
            if(!$sholat){
                return response()->json([
                    'code' => 404,
                    'message' => 'Data Sholat Tidak Ada!',
                ]);
            }

            DB::beginTransaction();
                PrayerSchedule::where('id', $id)->delete();
            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Hapus Data Sholat',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Menghapus Data Sholat!',
            ]);
        }
    }
}
