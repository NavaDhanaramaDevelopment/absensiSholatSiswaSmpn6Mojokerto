<?php

use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Master\StudentController;
use App\Http\Controllers\Master\SholatController;
use App\Http\Controllers\Master\KelasController;
use App\Http\Controllers\Master\TeacherController;
use App\Http\Controllers\Scanner\ScanBarcodeController;
use App\Http\Controllers\Scanner\ScanController;
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
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['web', 'auth', 'roles', 'check.device']], function(){
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

    // KELAS
    Route::resource('classes', KelasController::class);
    Route::get('get-data', [KelasController::class, 'populateData'])->name('classes.data');

    // Siswa
    Route::group(['prefix' => 'siswa'], function(){
        Route::get('', [StudentController::class, 'index'])->name('student');
        Route::get('get-data', [StudentController::class, 'populateData'])->name('student.data');
        Route::POST('get-data', [StudentController::class, 'populateData'])->name('student.data');
        Route::get('add-data', [StudentController::class, 'add'])->name('student.add');
        Route::post('add-data', [StudentController::class, 'store'])->name('student.store');
        Route::get('edit-data/{id}', [StudentController::class, 'edit'])->name('student.edit');
        Route::post('update-data/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::delete('delete-data/{id}', [StudentController::class, 'destroy'])->name('student.delete');
        Route::post('import', [StudentController::class, 'importSiswa'])->name('student.import');
        Route::get('export', [StudentController::class, 'exportSiswa'])->name('student.export');
    });

    // sholat
    Route::group(['prefix' => 'sholat'], function(){
        Route::get('', [SholatController::class, 'index'])->name('sholat');
        Route::get('get-data', [SholatController::class, 'populateData'])->name('sholat.data');
        Route::POST('get-data', [SholatController::class, 'populateData'])->name('sholat.data');
        Route::get('add-data', [SholatController::class, 'add'])->name('sholat.add');
        Route::post('add-data', [SholatController::class, 'store'])->name('sholat.store');
        Route::get('edit-data/{id}', [SholatController::class, 'edit'])->name('sholat.edit');
        Route::post('update-data/{id}', [SholatController::class, 'update'])->name('sholat.update');
        Route::delete('delete-data/{id}', [SholatController::class, 'destroy'])->name('sholat.delete');
        Route::post('import', [SholatController::class, 'importSiswa'])->name('sholat.import');
        Route::get('export', [SholatController::class, 'exportSiswa'])->name('sholat.export');
    });

    // Attendance
    Route::group(['prefix' => 'Absensi'], function(){
        Route::get('/', [AttendanceController::class, 'index'])->name('attendance');
        Route::get('/get-data', [AttendanceController::class, 'populateData'])->name('attendance.data');
        Route::post('/get-data', [AttendanceController::class, 'populateData'])->name('attendance.data');
        Route::get('export', [AttendanceController::class, 'exportAbsence'])->name('attendance.export');
    });

    // Whatsapp
    Route::group(['prefix' => 'Whatsapp'], function(){
        Route::get('/', [WhatsAppController::class, 'index'])->name('whatsapp');
        Route::post('/send-message', [WhatsAppController::class, 'sendMessage'])->name('whatsapp.sendMessage');
    });

    // Interface Scan Barcode
    Route::group(['prefix' => 'Scan-Absensi'], function(){
        Route::get('/', [ScanController::class, 'index'])->name('attendanceScan');
        Route::get('get-data-scan-absensi', [ScanController::class, 'getDataScanAbsensi'])->name('getDataScanAbsensi');
    });

    // Scan Barcode
    Route::group(['prefix' => 'scan-barcode'], function(){
        Route::get('', [ScanBarcodeController::class, 'index'])->name('scanBarcode');
        Route::get('get-data', [ScanBarcodeController::class, 'indexData'])->name('scanBarcode.data');
        Route::post('/', [ScanBarcodeController::class, 'attendanceGuest'])->name('scanBarcode.attendanceGuest');
    });
});
