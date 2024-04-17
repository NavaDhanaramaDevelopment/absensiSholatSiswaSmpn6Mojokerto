<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerSchedule extends Model
{
    use HasFactory;
    protected $table = 'm_prayer_schedules';
    protected $fillable = [
        'sholat',
        'start_clock',
        'end_clock'
    ];
}
