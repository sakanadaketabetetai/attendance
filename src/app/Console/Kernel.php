<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Break_time;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function (){
            $this->checkAndUpdateWorkStatus();
        })->dailyAt('0:00');
    }

    protected function checkAndUpdateWorkStatus()
    {
        //勤務中のユーザーを取得
        $workingUsers = User::where('is_working', true)->get();

        foreach($workingUsers as $user){
            //最新の出勤記録を取得
            $attendance = Attendance::where('user_id',$user->id)->latest()->first();
            $break_times = Break_time::where('attendance_id',$attendance->id)->get();
            \Log::info("Latest attendance: " . json_encode($attendance));

            if($attendance && !$attendance->clock_out_time){
                //当日の勤務時間の合計を計算
                $clockInTime = Carbon::parse($attendance->clock_in_time);
                $clockOutTime = Carbon::parse('23:59:59');
                $totalClockSeconds = $clockOutTime->diffInSeconds($clockInTime);
                //勤務時間を秒数から時間、分、秒を計算
                $clock_hours = floor($totalClockSeconds/3600);
                $clock_minutes = floor(($totalClockSeconds % 3600) / 60);
                $clock_seconds = $totalClockSeconds % 60;
                //勤務時間合計のフォーマットをHH:MM:SSにし$totalClockTimteに代入
                $totalClockTime = sprintf('%02d:%02d:%02d', $clock_hours, $clock_minutes, $clock_seconds);

                // 当日の休憩時間を記録
                $totalBreakSeconds = 0;
                foreach ($break_times as $break_time){
                    if($break_time->breakTime){
                        list($hours, $minutes, $seconds) = explode(':', $break_time->breakTime);
                        $totalBreakSeconds += ($hours * 3600) + ($minutes * 60) + $seconds;
                    }
                }
                //休憩時間を秒数から時間、分、秒を計算
                $break_hours = floor($totalBreakSeconds/3600);
                $break_minutes = floor(($totalBreakSeconds % 3600) / 60);
                $break_seconds = $totalBreakSeconds % 60;
                //勤務時間合計のフォーマットをHH:MM:SSにし$totalClockTimteに代入
                $totalBreakTime = sprintf('%02d:%02d:%02d', $break_hours, $break_minutes, $break_seconds);
                //Attendanceテーブルに当日までの勤務実績を記録
                $attendance->update([
                    'clock_out_time' => $clockOutTime,
                    'total_clock_time' => $totalClockTime,
                    'total_break_time' =>$totalBreakTime
                ]);
                // 状況を退勤に変更
                $user->update([
                    'is_working' => 0
                ]);

                \Log::info("Updated attendance: " . $attendance->id);

 

                //翌日の0:00に新しい勤務開始を記録
                $newAttendance = new Attendance();
                $newAttendance->user_id = $user->id;
                $newAttendance->clock_in_time = Carbon::parse('00:00:00')->addDay();
                $newAttendance->save();
                // 状況を出勤に変更
                $user->update([
                    'is_working' => 1
                ]);
                \Log::info("Created new attendance: " . $newAttendance->id);
            }
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
