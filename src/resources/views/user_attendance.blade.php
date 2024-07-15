@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user_attendance.css') }}">
<link rel="stylesheet" href="{{ asset('css/custom-pagination.css') }}">
@endsection

@section('content')
<div class="user_attendance-content">
    <div class="user_attendance-title">
        <h2 class="title-text">{{ $user_name['name'] }}さんの勤怠管理一覧</h2>
    </div>
    @if($user_attendances->isNotEmpty())
        <table> 
            <tr>
                <th>勤務日</th>
                <th>勤務開始</th>
                <th>勤務終了</th>
                <th>休憩時間</th>
                <th>勤務時間</th>
            </tr>
            @foreach($user_attendances as $user_attendance)
                @php
                    $clockInTimeformatted = \Carbon\Carbon::parse($user_attendance->clock_in_time)->format('H:i:s');
                    $clockOutTimeformatted = \Carbon\Carbon::parse($user_attendance->clock_out_time)->format('H:i:s');
                @endphp
                <tr>
                    <td>{{ $user_attendance->date }}</td>
                    <td>{{ $clockInTimeformatted }}</td>
                    <td>{{ $clockOutTimeformatted }}</td>
                    <td>{{ $user_attendance->total_break_time }}</td>
                    <td>{{ $user_attendance->total_clock_time }}</td>
                </tr>
            @endforeach
        </table>
        {{ $user_attendances->links() }}
    @endif
</div>
@endsection