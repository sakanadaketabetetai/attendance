<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index(){
        $user = Auth::user();
        $attendance = Attendance::where('user_id', $user->id)->latest()->first();
        return view('index',compact('user', 'attendance'));
    }

    public function clock_in(){
        $user = Auth::user();

        $oldTimestamp = Attendance::where('user_id', $user->id)->latest()->first();
        $oldTimestampDay = null; // 初期化

        if($oldTimestamp){
            $oldTimestampClockIn = new Carbon($oldTimestamp->clock_in_time);
            $oldTimestampDay = $oldTimestampClockIn->startOfDay();
        } 

        $newTimestampDay = Carbon::today();

        if(($oldTimestampDay == $newTimestampDay) && (empty($oldTimestamp->clock_out_time))){
            return redirect()->back()->with('error', 'すでに出勤打刻がされています');
        }
        $timestamp = Attendance::create([
            'user_id' => $user->id,
            'clock_in_time' => Carbon::now(),
            'date' => $newTimestampDay
        ]);

        return redirect()->back()->with('my_status', '出勤打刻が完了しました');  
    }

    public function clock_out(){
        $user = Auth::user();
        $timestamp = Attendance::where('user_id', $user->id)->latest()->first();

        if(!empty($timestamp->clock_out_time)){
            return redirect()->back()->with('error', 'すでに退勤の打刻がされているか、出勤打刻がされていません');
        }
        $clockInTime = Carbon::parse($timestamp->clock_in_time);
        $clockOutTime = Carbon::now();

        $totalClockSeconds = $clockOutTime->diffInSeconds($clockInTime);

        //秒数から時間、分、秒を計算
        $hours = floor($totalClockSeconds/3600);
        $minutes = floor(($totalClockSeconds % 3600) / 60);
        $seconds = $totalClockSeconds % 60;

        //フォーマットをHH:MM:SSにし$totalClockTimteに代入
        $totalClockTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        $timestamp->update([
            'clock_out_time' => $clockOutTime,
            'total_clock_time' => $totalClockTime
        ]);

        return redirect()->back()->with('my_status', '退勤打刻が完了しました');
    }


    public function break_start(){
        $user = Auth::user();

        $latestAttendance = Attendance::where('user_id', $user->id)->latest()->first();

        if(!$latestAttendance){
            return redirect()->back()->with('break_error', '出勤記録が見つかりません');
        }

        if((!empty($latestAttendance->clock_in_time)) && (empty($latestAttendance->break_start_time))){
            $latestAttendance->update([
                'break_start_time' => Carbon::now()
            ]);  
            return redirect()->back()->with('break_status', '休憩を開始しました');  
        } 

        if((empty($latestAttendance->clock_in_time)) || (!empty($latestAttendance->break_start_time))){
            return redirect()->back()->with('break_error', '休暇中又はすでに休憩開始されています');
        }
    }

    public function break_end(){
        $user = Auth::user();
        $timestamp = Attendance::where('user_id', $user->id)->latest()->first();
        
        if(!$timestamp || empty($timestamp->clock_in_time)){
            return redirect()->back()->with('break_error', 'すでに休憩が終了されています');
        }

        if(!empty($timestamp->break_end_time)){
            return redirect()->back()->with('break_error', 'すでに休憩が終了されています');
        }
        
        if(empty($timestamp->break_start_time)){
            return redirect()->back()->with('break_error', '休憩が開始されていません');
        }
        $breakStartTime = Carbon::parse($timestamp->break_start_time);
        $breakEndTime = Carbon::now();
        $totalBreakSeconds = $breakEndTime->diffInSeconds($breakStartTime);

        //秒数から時間、分、秒を計算
        $hours = floor($totalBreakSeconds / 3600);
        $minutes = floor(($totalBreakSeconds % 3600) / 60);
        $seconds = $totalBreakSeconds % 60;
        
        //フォーマットをHH:MM:SSにし$totalClockTimteに代入
        $totalBreakTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        $timestamp->update([
            'break_end_time' => $breakEndTime,
            'total_break_time' => $totalBreakTime
        ]);

        return redirect()->back()->with('break_status', '休憩が終了しました');
    }

    public function filter(Request $request){
        $date = $request->input('date');

        $attendances = Attendance::whereDate('clock_in_time', $date)->get();
        return view('attendance',['attendances' => $attendances, 'selectDate' => $date]);
    }

}

