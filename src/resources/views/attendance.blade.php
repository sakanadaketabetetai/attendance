@extends('layouts.app')

@section('css')

@endsection

@section('content')
<div class="">
    <form action="{{ route('attendance.filter') }}" method="get">
        @csrf
        <input type="date" name="date" id="date" value="{{ $selectDate ?? '' }}">
        <button type="submit">表示</button>
    </form>
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
                <tr>
                    <td>{{ $attendance->user->name }}</td>
                    <td>{{ $attendance->clock_in_time }}</td>
                    <td>{{ $attendance->clock_out_time }}</td>
                    <td>{{ $attendance->total_break_time }}</td>
                    <td>{{ $attendance->total_clock_time }}</td>
                </tr>
            @endforeach
        </table>
    @endif
</div>
@endsection

