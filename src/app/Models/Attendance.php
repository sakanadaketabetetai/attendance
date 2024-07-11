<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','date','clock_in_time',
        'clock_out_time','total_break_time',
        'total_clock_time','break_start_time',
        'break_end_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
