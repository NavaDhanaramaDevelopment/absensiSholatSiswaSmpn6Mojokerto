<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    use HasFactory;
    protected $table = 'm_user_accesses';
    protected $fillable = [
        'role_id',
        'module_function_id',
    ];
}
