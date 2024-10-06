<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $table = 'm_teachers';
    protected $fillable = [
        'user_id',
        'kode_guru',
        'nama_depan',
        'nama_belakang',
        'jenis_kelamin',
        'no_telepon',
        'wali_kelas'
    ];

    public static function getKelasAuth(){
        $user_id = Auth()->user()->id;
        $teacher = Teacher::where('user_id', $user_id)->first();

        if($teacher){
            return $teacher->wali_kelas;
        }else{
            return FALSE;
        }
    }
}
