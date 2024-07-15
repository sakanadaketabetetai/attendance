@extends('layouts.app')

@section('css')

@endsection

@section('content')
<div class="users_content">
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



@endsection