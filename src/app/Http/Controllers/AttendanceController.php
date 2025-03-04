<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Break_time;
use App\Models\User;

class AttendanceController extends Controller
{
    public function index(){
        $user = Auth::user();
        $attendance = Attendance::where('user_id', $user->id)->latest()->first();
        $break_time = $attendance ? Break_time::where('attendance_id', $attendance->id)->latest()->first() : null;
        return view('index',compact('user', 'attendance','break_time'));
    }

    public function clock_in(){
        $user = Auth::user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)->whereDate('clock_in_time', $today)->latest()->first();

        if($attendance){
            if (empty($attendance->clock_out_time)){
                return redirect()->back()-with('error', 'すでに出勤しています。');
            }else {
                return redirect()->back()->with('error', '本日の勤務は終了しています。');
            }
        }

        $timestamp = Attendance::create([
            'user_id' => $user->id,
            'clock_in_time' => Carbon::now(),
            'date' => $today
        ]);

        $user->update([
            'is_working' => 1
        ]);

        return redirect()->back()->with('my_status', '出勤打刻が完了しました');  
    }

    public function clock_out(){
        $user = Auth::user();
        $latestAttendance = Attendance::where('user_id', $user->id)->latest()->first();

        if(!empty($latestAttendance->clock_out_time)){
            return redirect()->back()->with('error', 'すでに退勤の打刻がされているか、出勤打刻がされていません');
        }
        //勤務時間の合計を計算
        $clockInTime = Carbon::parse($latestAttendance->clock_in_time);
        $clockOutTime = Carbon::now();
        $totalClockSeconds = $clockOutTime->diffInSeconds($clockInTime);

        //勤務時間を秒数から時間、分、秒を計算
        $clock_hours = floor($totalClockSeconds/3600);
        $clock_minutes = floor(($totalClockSeconds % 3600) / 60);
        $clock_seconds = $totalClockSeconds % 60;

        //勤務時間合計のフォーマットをHH:MM:SSにし$totalClockTimteに代入
        $totalClockTime = sprintf('%02d:%02d:%02d', $clock_hours, $clock_minutes, $clock_seconds);

        //休憩時間の合計を計算        
        $breakTimes = Break_time::where('attendance_id',$latestAttendance->id)->get();
        $totalBreakSeconds = 0;
        foreach ($breakTimes as $breakTime){
            if($breakTime->breakTime){
                list($hours, $minutes, $seconds) = explode(':', $breakTime->breakTime);
                $totalBreakSeconds += ($hours * 3600) + ($minutes * 60) + $seconds;
            }
        }

        //休憩時間を秒数から時間、分、秒を計算
        $break_hours = floor($totalBreakSeconds/3600);
        $break_minutes = floor(($totalBreakSeconds % 3600) / 60);
        $break_seconds = $totalBreakSeconds % 60;
 
        //勤務時間合計のフォーマットをHH:MM:SSにし$totalClockTimteに代入
        $totalBreakTime = sprintf('%02d:%02d:%02d', $break_hours, $break_minutes, $break_seconds);
        $latestAttendance->update([
            'clock_out_time' => $clockOutTime,
            'total_clock_time' => $totalClockTime,
            'total_break_time' =>$totalBreakTime
        ]);

        $user->update([
            'is_working' => 0
        ]);

        return redirect()->back()->with('my_status', '退勤打刻が完了しました');
    }


    public function break_start(){
        $user = Auth::user();
        //ユーザーの最新の勤怠データを採取
        $latestAttendance = Attendance::where('user_id', $user->id)->latest()->first();

        if(!$latestAttendance){
            return redirect()->back()->with('break_error', '出勤記録が見つかりません');
        }

        $latestBreakTime = Break_time::where('attendance_id', $latestAttendance->id)->latest()->first();

        if((!empty($latestAttendance->clock_in_time)) && (empty($latestBreakTime->break_start_time)) || 
            !empty($latestBreakTime->break_start_time) && !empty($latestBreakTime->break_start_time))
        {
            Break_time::create([
                'attendance_id' => $latestAttendance->id,
                'break_start_time' => Carbon::now()
            ]);  
            return redirect()->back()->with('break_status', '休憩を開始しました');  
        } 

        if((empty($latestAttendance->clock_in_time)) || (!empty($latestAttendance->break_start_time)) && (empty($latestAttendance->break_end_time))){
            return redirect()->back()->with('break_error', '休暇中又はすでに休憩開始されています');
        }
    }

    public function break_end(){
        $user = Auth::user();
        $latestAttendance = Attendance::where('user_id', $user->id)->latest()->first();
        
        if(!$latestAttendance || empty($latestAttendance->clock_in_time)){
            return redirect()->back()->with('break_error', 'すでに休憩が終了されています');
        }

        $latestBreakTime = Break_time::where('attendance_id', $latestAttendance->id)->latest()->first();

        if(!empty($latestBreakTime->break_end_time)){
            return redirect()->back()->with('break_error', 'すでに休憩が終了されています');
        }
        
        if(empty($latestBreakTime->break_start_time)){
            return redirect()->back()->with('break_error', '休憩が開始されていません');
        }
        $breakStartTime = Carbon::parse($latestBreakTime->break_start_time);
        $breakEndTime = Carbon::now();
        $totalBreakSeconds = $breakEndTime->diffInSeconds($breakStartTime);

        //秒数から時間、分、秒を計算
        $hours = floor($totalBreakSeconds / 3600);
        $minutes = floor(($totalBreakSeconds % 3600) / 60);
        $seconds = $totalBreakSeconds % 60;
        
        //フォーマットをHH:MM:SSにし$totalClockTimteに代入
        $totalBreakTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        $latestBreakTime->update([
            'break_end_time' => $breakEndTime,
            'breakTime' => $totalBreakTime
        ]);

        return redirect()->back()->with('break_status', '休憩が終了しました');
    }

    public function filter($date = null){
        try {
            $date = $date ? Carbon::parse($date) : Carbon::today();
        } catch (\Exception $e) {
            $date = Carbon::today(); // 無効な日付の場合は今日の日付を使用
        }
        $attendances = Attendance::whereDate('clock_in_time', $date)->paginate(5);

        return view('attendance',compact('attendances', 'date'));
    }

    
    public function users(){
        $users = User::paginate(10);
        return view('users',compact('users'));
    }

    public function user_attendance($id){
        $user_name = User::find($id)->only('name');
        $user_attendances = Attendance::where('user_id',$id)->paginate(5);
        return view('user_attendance',compact('user_attendances','user_name'));
    }

}

