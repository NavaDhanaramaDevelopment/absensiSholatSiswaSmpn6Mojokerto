<?php

namespace App\Http\Controllers\Master;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ScannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.scanner.index');
    }

    public function populateData(Request $request){
        try {
            $scanner = User::where('role_id', 2)->whereNull('deleted_at')->get();

            return response()->json($scanner);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Mendapatkan Data Scanner!',
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.scanner.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
                $user = new User();
                $user->role_id = 2;
                $user->username = $request->username;
                $user->password = bcrypt($request->password);
                $user->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sukses Menambahkan data Scanner!'
            ]);
        }catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Menambahkan Data Scanner!',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $scanner = User::where('id', $id)
                    ->where('role_id', 2)
                    ->first();

        return view('master.scanner.add', [
            'scanner' => $scanner,
            'id'      => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
                User::where('id', $id)->update([
                    'username'  => $request->username,
                    'password'  => bcrypt($request->password)
                ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sukses Mengedit Data Scanner!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Mengedit Data Scanner!',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
                User::where('id', $id)->update([
                    'deleted_at'    => Carbon::now()
                ]);
            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Hapus Data Scanner',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'code'      =>  500,
                'message'   => 'Gagal Menghapus Data Scanner!',
            ]);
        }
    }
}
