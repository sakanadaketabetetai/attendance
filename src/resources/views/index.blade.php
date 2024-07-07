@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <div class="index_content">
        <div class="index_title">
            <h2>{{ $user_name }}さんお疲れ様です!</h2>
        </div>
        <div class="index_content">
            <div class="index_clock">
                <form action="{{ route('clock_in') }}" method="post">
                    @csrf
                    <div class="index_clockIn">
                        <!-- <input type="hidden" name="clock_in_time"> -->
                        <button class="index_clockIn-button" type="submit">勤務開始</button>
                    </div>
                </form>
                <form action="{{ route('clock_out') }}" method="post">
                    @csrf
                    <div class="index_clockOut">
                        <!-- <input type="hidden" name="clock_out_time"> -->
                        <button class="index_clockOut-button" type="submit">勤務終了</button>
                    </div>
                </form>
            </div>
            <div class="index_break">
                <div class="index_breakStart">
                    <input type="hidden" name="break_start_time">
                    <button class="index_breakStart-button">休憩開始</button>
                </div>
                <div class="index_breakEnd">
                    <input type="hidden" name="break_end_time">
                    <button class="index_breakEnd-button">休憩終了</button>
                </div>
            </div>
        </div>
    </div>

@endsection