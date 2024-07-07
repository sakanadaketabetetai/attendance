<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index(){
        $user_name = Auth::user()->name;
        return view('index',compact('user_name'));
    }

    public function clock_in(){
        $user = Auth::user();

        $oldTimestamp = Attendance::where('user_id', $user->id)->latest()->first();
        $oldTimestampDay = null; // 初期化

        if($oldTimestamp){
            $oldTimestampClockStart = new Carbon($oldTimestamp->clock_start_time);
            $oldTimestampDay = $oldTimestampClockStart->startOfDay();
        } 

        $newTimestampDay = Carbon::today();

        if(($oldTimestampDay == $newTimestampDay) && (empty($oldTimestamp->clock_start_time))){
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

        $timestamp->update([
            'clock_out_time' => Carbon::now()
        ]);

        return redirect()->back()->with('my_status', '退勤打刻雅完了しました');
    }

}

