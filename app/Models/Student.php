<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'm_students';
    protected $fillable = [
        'user_id',
        'nisn',
        'nama_depan',
        'nama_belakang',
        'kelas',
        'jenis_kelamin',
        'no_telepon',
        'alamat'
    ];
}
