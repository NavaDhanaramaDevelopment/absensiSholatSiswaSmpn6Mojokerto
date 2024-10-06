<?php

namespace App\Http\Controllers\Master;

use App\Exports\SiswaExport;
use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Kelas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index(){
        $kelas = Teacher::getKelasAuth();
        return view('master.student.index', [
            'kelas_data' => Kelas::all(),
            'kelas' => $kelas
        ]);
    }

    public function populateData(Request $request){
        try {

            $kelas = Teacher::getKelasAuth();
            if($request->method() == "POST"){
                $students = Student::select('id', DB::raw("CONCAT(nama_depan, ' ', nama_belakang) AS nama_lengkap"), 'nisn', 'kelas', 'no_telepon');
                if($request->kelas != ""){
                    $students->where('kelas', $request->kelas)->whereNull('deleted_at');
                }else{
                    $students->whereNull('deleted_at');
                }
            }else{
                $students = Student::select('id', DB::raw("CONCAT(nama_depan, ' ', nama_belakang) AS nama_lengkap"), 'nisn', 'kelas', 'no_telepon')
                            ->whereNull('deleted_at')
                            ->where('kelas', $kelas);
            }

            return response()->json($students->get());
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
        return view('master.student.add');
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
                $user = new User();
                $user->role_id = 1;
                $user->username = $request->nisn;
                $user->password = $request->password;
                $user->save();

                $student = Student::create([
                    'user_id'           => $user->id,
                    'nisn'              => $request->nisn,
                    'nama_depan'        => $request->nama_depan,
                    'nama_belakang'     => $request->nama_belakang,
                    'kelas'             => $request->kelas,
                    'jenis_kelamin'     => $request->jenis_kelamin,
                    'no_telepon'        => $request->no_telepon,
                    'alamat'            => $request->alamat
                ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sukses Menambahkan data Siswa!'
            ]);
        }catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Menambahkan Data Siswa!',
            ]);
        }
    }

    public function edit($id){
        $student = Student::where('m_students.id', $id)
                    ->join('users', 'users.id', '=', 'm_students.user_id')
                    ->first();

        return view('master.student.add', [
            'student' => $student,
            'id'      => $id
        ]);
    }

    public function update(Request $request, $id){
        try {
            $student = Student::where('id', $id)->first();
            DB::beginTransaction();
                User::where('id', $student->user_id)->update([
                    'username'  => $request->nisn
                ]);

                $student = Student::where('id', $id)->update([
                    'nisn'              => $request->nisn,
                    'nama_depan'        => $request->nama_depan,
                    'nama_belakang'     => $request->nama_belakang,
                    'kelas'             => $request->kelas,
                    'jenis_kelamin'     => $request->jenis_kelamin,
                    'no_telepon'        => $request->no_telepon,
                    'alamat'            => $request->alamat
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
            $student = Student::where('id', $id)->first();
            if(!$student){
                return response()->json([
                    'code' => 404,
                    'message' => 'Data Siswa Tidak Ada!',
                ]);
            }

            DB::beginTransaction();
                Student::where('id', $id)->update([
                    'deleted_at'    => Carbon::now()
                ]);
            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Hapus Data Siswa',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Menghapus Data Siswa!',
            ]);
        }
    }

    public function importSiswa(Request $request){
        try {
            $file = $request->file('file');

            DB::beginTransaction();
            Excel::import(new SiswaImport, $file);
            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Data Siswa Berhasil Diimport!',
            ]);
        }  catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Import Data Siswa!',
            ]);
        }
    }

    public function exportSiswa()
    {
        return Excel::download(new SiswaExport, 'siswa.xlsx');
    }
}
