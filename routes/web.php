<?php

use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Master\StudentController;
use App\Http\Controllers\Master\TeacherController;
use App\Http\Controllers\WhatsApp\WhatsAppController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('loginPost');

Route::group(['middleware' => ['web', 'auth', 'roles']], function(){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // GURU
    Route::group(['prefix' => 'guru'], function(){
        Route::get('', [TeacherController::class, 'index'])->name('teacher');
        Route::get('get-data', [TeacherController::class, 'populateData'])->name('teacher.data');
        Route::get('add-data', [TeacherController::class, 'add'])->name('teacher.add');
        Route::post('add-data', [TeacherController::class, 'store'])->name('teacher.store');
        Route::get('edit-data/{id}', [TeacherController::class, 'edit'])->name('teacher.edit');
        Route::post('update-data/{id}', [TeacherController::class, 'update'])->name('teacher.update');
        Route::delete('delete-data/{id}', [TeacherController::class, 'destroy'])->name('teacher.delete');
    });

    // Siswa
    Route::group(['prefix' => 'siswa'], function(){
        Route::get('', [StudentController::class, 'index'])->name('student');
        Route::get('get-data', [StudentController::class, 'populateData'])->name('student.data');
        Route::get('add-data', [StudentController::class, 'add'])->name('student.add');
        Route::post('add-data', [StudentController::class, 'store'])->name('student.store');
        Route::get('edit-data/{id}', [StudentController::class, 'edit'])->name('student.edit');
        Route::post('update-data/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::delete('delete-data/{id}', [StudentController::class, 'destroy'])->name('student.delete');
    });

    // Attendance
    Route::group(['prefix' => 'Absensi'], function(){
        Route::get('/', [AttendanceController::class, 'index'])->name('attendance');
    });

    // Attendance
    Route::group(['prefix' => 'Whatsapp'], function(){
        Route::get('/', [WhatsAppController::class, 'index'])->name('whatsapp');
    });
});
