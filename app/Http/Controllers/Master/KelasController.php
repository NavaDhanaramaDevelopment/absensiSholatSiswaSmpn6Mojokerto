<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KelasController extends Controller
{
    public function index(){
        return view('master.class.index');
    }

    public function populateData(Request $request){
        try {
            $kelas = Kelas::all();

            return response()->json($kelas);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Mendapatkan Data Kelas!',
            ]);
        }
    }

    public function create(){
        $teachers = Teacher::all();
        return view('master.class.add', [
            'teachers' => $teachers
        ]);
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
            Kelas::create($request->all());
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sukses Menambahkan data Kelas!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Menambahkan Data Kelas!',
            ]);
        }
    }

    public function show($id){
        $kelas = Kelas::where('id', $id)->first();
        $teachers = Teacher::all();

        return view('master.class.add', [
            'kelas' => $kelas,
            'teachers' => $teachers,
            'id' => $id
        ]);
    }

    public function update($id, Request $request){
        try {
            DB::beginTransaction();
            Kelas::where('id', $id)->update([
                'nama_kelas' => $request->nama_kelas
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Sukses Mengedit Data Siswa!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Mengedit Data Siswa!',
            ]);
        }
    }

    public function destroy($id){
        try {
            $kelasCheck = Kelas::where('id', $id)->first();
            if(!$kelasCheck){
                return response()->json([
                    'code' => 404,
                    'message' => 'Data Kelas Tidak Ada!',
                ]);
            }

            DB::beginTransaction();
            Kelas::where('id', $id)->delete();
            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Hapus Data Kelas',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Mengedit Data Siswa!',
            ]);
        }
    }
}
