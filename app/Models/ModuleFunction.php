<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleFunction extends Model
{
    use HasFactory;
    protected $table = 'm_module_functions';
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'module_id',
        'routes',
        'created_at',
        'updated_at'
    ];
}
