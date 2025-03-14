<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon\Carbon;

class SiswaImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (empty(array_filter($row, 'strlen')) || !isset($row[0]) || trim($row[0]) === '') {
            return null;
        }

        $kelas = Kelas::firstOrCreate(
            ['nama_kelas' => $row[3]],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        $siswa = Student::where('nisn', $row[0])->whereNull('deleted_at')->first();

        $user = User::where('username', $row[0])->first();

        if (!$siswa) {
            $siswa = Student::create([
                'nisn'          => $row[0],
                'nama_depan'    => $row[1],
                'nama_belakang' => $row[2],
                'kelas'         => $row[3],
                'jenis_kelamin' => $row[4],
                'no_telepon'    => $row[5],
                'alamat'        => $row[6],
            ]);
        } else {
            $siswa->update([
                'nama_depan'    => $row[1],
                'nama_belakang' => $row[2],
                'kelas'         => $row[3],
                'jenis_kelamin' => $row[4],
                'no_telepon'    => $row[5],
                'alamat'        => $row[6]
            ]);
        }

        if (!$user) {
            $user = User::create([
                'role_id'   => 3,
                'username'  => $row[0],
                'password'  => bcrypt($row[0]),
            ]);
        } else {
            if ($siswa->user_id) {
                $user->update([
                    'username'  => $row[0],
                    'password'  => bcrypt($row[0]),
                ]);
            }
        }

        $siswa->update(['user_id' => $user->id]);

        return $siswa;
    }

    public function startRow(): int
    {
        return 2;
    }
}
