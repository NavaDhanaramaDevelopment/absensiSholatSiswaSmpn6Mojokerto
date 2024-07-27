<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SiswaImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(empty(array_filter($row))) {
            return null;
        }
        $siswa = Student::where('nisn', $row[0])->whereNull('deleted_at')->first();

        if($siswa){
            return null;
        }
        $user = User::where('username', $row[0])->first();

        if (!$user) {
            $user = User::create([
                'role_id'   => 3,
                'username'  => $row[0],
                'password'  => bcrypt($row[0]),
            ]);
        }else{
            User::where('nisn', $row[0])->update([
                'username'  => $row[0],
                'password'  => bcrypt($row[0]),
            ]);
        }

        $namaDepan = '';
        $namaBelakang = '';
        $namaArray = explode(' ', $row[1]);
        $namaDepan = $namaArray[0];
        if (count($namaArray) > 1) {
            $namaBelakang = implode(' ', array_slice($namaArray, 1));
        }

        return new Student([
            'user_id'       => $user->id,
            'nisn'          => $row[0],
            'nama_depan'    => $namaDepan,
            'nama_belakang' => $namaBelakang,
            'kelas'         => $row[2],
            'jenis_kelamin' => $row[3],
            'no_telepon'    => $row[4],
            'alamat'        => $row[5],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
