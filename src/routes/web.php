<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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



Route::middleware(['auth','verified'])->group(function(){
    Route::get('/',[AttendanceController::class, 'index']);
    Route::post('/clock_in',[AttendanceController::class, 'clock_in'])->name('clock_in');
    Route::post('/clock_out',[AttendanceController::class, 'clock_out'])->name('clock_out');
    Route::post('/break_start',[AttendanceController::class, 'break_start'])->name('break_start');
    Route::post('/break_end',[AttendanceController::class, 'break_end'])->name('break_end');
    Route::get('/attendance/{date?}', [AttendanceController::class, 'filter'])->name('attendance');
    Route::get('/users', [AttendanceController::class, 'users'])->name('users');
    Route::get('/user_attendance/{id?}', [AttendanceController::class, 'user_attendance'])->name('user_attendance');
    
});

Route::get('/email/verify', function(){
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/'); // 認証後のリダイレクト先を指定
})->middleware(['auth', 'signed'])->name('verification.verify');

// メール認証通知の再送信
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

