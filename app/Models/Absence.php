<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;
    protected $table = 't_absences';
    protected $fillable = [
        'student_id',
        'prayer_schedule_id',
        'barcode_id',
        'check_in',
        'is_late',
        'is_alpha'
    ];
}
