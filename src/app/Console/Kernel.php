<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        $schedule->call(function(){
            $this->chechAndUpdateWorkStatus();
        })->dailyAt('23:59');
    }

    protected function checkAndUpdateWorkStatus()
    {
        //勤務中のユーザーを取得
        $workingUsers = User::where('is_working', true)->get();

        foreach($workingUsers as $user){
            //最新の出勤記録を取得
            $attendance = Attendance::where('user_id',$user->id)->latest()->first();

            if($attendance && !$attendance->clock_out_time){
                //勤務終了を記録
                $attendance->clock_out_time = Carbon::parse('23:59:59');
                $attendance->save();

                //翌日の0:00に新しい勤務開始を記録
                $newAttendance = new Attendance();
                $newAttendance->user_id = $user->id;
                $newAttendance->clock_in_time = Carbon::parse('00:00:00')->addDay();
                $attendance->save();
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
