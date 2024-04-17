<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use HasFactory;
    protected $table = 't_barcodes';
    protected $fillable = [
        'student_id',
        'barcode_value',
        'is_scanned'
    ];
}
