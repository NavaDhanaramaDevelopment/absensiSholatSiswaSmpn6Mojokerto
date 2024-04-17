<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $table = 'm_modules';
    protected $fillable = [
        'module',
        'is_show',
        'created_at',
        'updated_at'
    ];
}
