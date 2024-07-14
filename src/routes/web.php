<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function(){
    Route::get('/',[AttendanceController::class, 'index']);
    Route::post('/clock_in',[AttendanceController::class, 'clock_in'])->name('clock_in');
    Route::post('/clock_out',[AttendanceController::class, 'clock_out'])->name('clock_out');
    Route::post('/break_start',[AttendanceController::class, 'break_start'])->name('break_start');
    Route::post('/break_end',[AttendanceController::class, 'break_end'])->name('break_end');
    Route::get('/attendance/{date?}', [AttendanceController::class, 'filter'])->name('attendance');
    Route;;get('auto-clock-out-in', [AttendanceController::class, 'autoClockOutIn'])->name('auto.clock.out.in');
});

