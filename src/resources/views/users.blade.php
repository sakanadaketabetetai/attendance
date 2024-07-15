@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
<link rel="stylesheet" href="{{ asset('css/custom-pagination.css') }}">
@endsection

@section('content')
<div class="users_content">
    <div class="users_title">
        <h2 class="title-text">ユーザー一覧</h2>
    </div>
    <div class="users_table">
        <table>
            <tr>
                <th>ユーザー名</th>
                <th>勤怠管理表</th>
                <th>勤務中</th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td><a href="{{ route('user_attendance',['id'=> $user->id]) }}">勤怠管理表</a></td>
                <td>{{ $user->is_working ? "勤務中" : "退勤中" }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    {{ $users->links() }}
</div>



@endsection