<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    public function index(){
        return view('master.teacher.index');
    }

    public function populateData(Request $request){
        try {
            $teachers = Teacher::select('id', DB::raw("CONCAT(nama_depan, ' ', nama_belakang) AS nama_lengkap"), 'kode_guru', 'no_telepon', 'wali_kelas')->whereNull('deleted_at')->get();

            return response()->json($teachers);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Mendapatkan Data Guru!',
            ]);
        }
    }

    public function add(){
        $kelas = Kelas::all();
        return view('master.teacher.add', [
            'kelas' => $kelas
        ]);
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();
                $user = new User();
                $user->role_id = 4;
                $user->username = $request->kode_guru;
                $user->password = bcrypt($request->password);
                $user->save();

                $teacher = Teacher::create([
                    'user_id'           => $user->id,
                    'kode_guru'         => $request->kode_guru,
                    'nama_depan'        => $request->nama_depan,
                    'nama_belakang'     => $request->nama_belakang,
                    'jenis_kelamin'     => $request->jenis_kelamin,
                    'no_telepon'        => $request->no_telepon,
                    'wali_kelas'        => $request->wali_kelas
                ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sukses Menambahkan data Guru!'
            ]);
        }catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Menambahkan Data Guru!',
            ]);
        }
    }

    public function edit($id){
        $kelas = Kelas::all();
        $teacher = Teacher::where('m_teachers.id', $id)
                    ->join('users', 'users.id', '=', 'm_teachers.user_id')
                    ->first();

        return view('master.teacher.add', [
            'teacher' => $teacher,
            'id'      => $id,
            'kelas'   => $kelas
        ]);
    }

    public function update(Request $request, $id){
        try {
            $teacher = Teacher::where('id', $id)->first();
            DB::beginTransaction();
                User::where('id', $teacher->user_id)->update([
                    'username'  => $request->kode_guru,
                    'password'  => bcrypt($request->password)
                ]);

                $teacher = Teacher::where('id', $id)->update([
                    'kode_guru'         => $request->kode_guru,
                    'nama_depan'        => $request->nama_depan,
                    'nama_belakang'     => $request->nama_belakang,
                    'jenis_kelamin'     => $request->jenis_kelamin,
                    'no_telepon'        => $request->no_telepon,
                    'wali_kelas'        => $request->wali_kelas
                ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sukses Mengedit data Guru!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Mengedit Data Guru!',
            ]);
        }
    }

    public function destroy($id){
        try {
            $teacher = Teacher::where('id', $id)->first();
            if(!$teacher){
                return response()->json([
                    'code' => 404,
                    'message' => 'Data Guru Tidak Ada!',
                ]);
            }

            DB::beginTransaction();
                Teacher::where('id', $id)->update([
                    'deleted_at'    => Carbon::now()
                ]);
            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Hapus Data Guru',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Menghapus Data Guru!',
            ]);
        }
    }
}
