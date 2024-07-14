@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="index_content">
        <div class="index_title">
            <h2 class="index_title-text">{{ $user->name }}さんお疲れ様です!</h2>
        </div>
        <div class="index_content">
            <div class="index_clock">
                <form action="{{ route('clock_in') }}" method="post">
                    @csrf
                    <div class="index_clockIn">
                        <button class="form_button {{ (isset($attendance->clock_in_time)) && (!isset($attendance->clock_out_time)) ? 'clocked_in':''}}" type="submit">勤務開始</button>
                    </div>
                </form>
                @if( session('error'))
                    <div>
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('clock_out') }}" method="post">
                    @csrf
                    <div class="index_clockOut">
                        <button class="form_button {{ (isset($attendance->clock_in_time)) && (isset($attendance->clock_out_time)) ? 'clocked_in':''}}" type="submit">勤務終了</button>
                    </div>
                </form>

            </div>
            <div class="index_break">
                <form action="{{ route('break_start') }}" method="post">
                    @csrf
                    <div class="index_breakStart">
                        @php
                            $isBreakstart = isset($break_time->break_start_time) && !isset($break_time->break_end_time) ||
                                            (isset($attendance->clock_in_time) && isset($attendance->clock_out_time));
                        @endphp
                        <button class="form_button {{ $isBreakstart ? 'clocked_in':''}}" type="submit">休憩開始</button>
                    </div>
                </form>
                @if( session('break_error'))
                    <div>
                        {{ session('break_error') }}
                    </div>
                @endif
                <form action="{{ route('break_end') }}" method="post">
                    @csrf
                    <div class="index_breakEnd">
                        @php
                            $isBreakEnd = isset($break_time->break_start_time) && isset($break_time->break_end_time) ||
                            (isset($attendance->clock_in_time) && !isset($break_time->break_start_time));
                        @endphp

                        <button class="form_button {{ $isBreakEnd ? 'clocked_in' : '' }}" type="submit">
                            休憩終了
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection