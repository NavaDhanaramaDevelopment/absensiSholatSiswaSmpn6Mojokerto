<?php

use App\Models\Absence;
use App\Models\Student;

function totalSiswa(){
    $students = Student::whereNull('deleted_at')->get();

    return count($students);
}

function totalMasukAbsen(){
    $absensies = Absence::whereNull('is_late')->whereNull('is_alpha')->get();

    return count($absensies);
}

function totalAlphaAbsen(){
    $absensiAlphaes = Absence::whereNotNull('is_alpha')->whereNull('is_late')->get();

    return count($absensiAlphaes);
}

function totalLateAbsen(){
    $absensiLates = Absence::whereNotNull('is_late')->whereNull('is_alpha')->get();

    return count($absensiLates);
}