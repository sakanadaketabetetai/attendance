<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'date' => "2024-07-07",
            'user_id' => "1",
            'clock_in_time' => "2024-07-07 09:30:00",
            'clock_out_time' => "2024-07-07 17:30:00",
            'break_start_time' => "2024-07-07 12:00:00",
            'break_end_time' => "2024-07-07 13:00:00"
        ];
        DB::table('attendances')->insert($param);
    }
}
