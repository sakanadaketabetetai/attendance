@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
<link rel="stylesheet" href="{{ asset('css/custom-pagination.css') }}">
@endsection

@section('content')
<div class="attendance_content">
    <div class="attendance_date">
        <a href="{{ route('attendance', ['date' => $date->copy()->subDay()->toDateString()]) }}" class="date_link">&lt;</a>
        <span class="date_text">{{ $date->toDateString() }}</span>
        <a href="{{ route('attendance', ['date' => $date->copy()->addDay()->toDateString()]) }}" class="date_link">&gt;</a>
    </div>
    @if($attendances->isNotEmpty())
        <table> 
            <tr>
                <th>名前</th>
                <th>勤務開始</th>
                <th>勤務終了</th>
                <th>休憩時間</th>
                <th>勤務時間</th>
            </tr>
            @foreach($attendances as $attendance)
                @php
                    $clockInTimeformatted = \Carbon\Carbon::parse($attendance->clock_in_time)->format('H:i:s');
                    $clockOutTimeformatted = \Carbon\Carbon::parse($attendance->clock_out_time)->format('H:i:s');
                @endphp
                <tr>
                    <td>{{ $attendance->user->name }}</td>
                    <td>{{ $clockInTimeformatted }}</td>
                    <td>{{ $clockOutTimeformatted }}</td>
                    <td>{{ $attendance->total_break_time }}</td>
                    <td>{{ $attendance->total_clock_time }}</td>
                </tr>
            @endforeach
        </table>    
        {{ $attendances->links() }}            
    @endif
</div>
@endsection

