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
                        <button class="form_button" type="submit">勤務開始</button>
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
                        <!-- <input type="hidden" name="clock_out_time"> -->
                        <button class="form_button" type="submit">勤務終了</button>
                    </div>
                </form>
                @if( session('my_status'))
                    <div>
                        {{ session('my_status') }}
                    </div>
                @endif
            </div>
            <div class="index_breakStart">
                <form action="{{ route('break_start') }}" method="post">
                    @csrf
                    <div class="index_break_start">
                        <button class="form_button" type="submit">休憩開始</button>
                    </div>
                </form>
                @if( session('break_error'))
                    <div>
                        {{ session('break_error') }}
                    </div>
                @endif
                <form action="{{ route('break_end') }}" method="post">
                    @csrf
                    <div class="index_break_end">
                        <button class="form_button" type="submit">休憩終了</button>
                    </div>
                </form>
                @if( session('break_status'))
                    <div>
                        {{ session('break_status') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection