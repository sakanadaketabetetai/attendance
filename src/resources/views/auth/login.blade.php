@extends('layouts.app')

@section('css')
 <link rel="stylesheet" href="{{ asset('login.css') }}">
@endsection

@section('content')

<div class="login_content">
    <div class="login_title">
        <h2>ログイン</h2>
    </div>
    <div class="login_form">
        <form action="/login" method="post">
            @csrf
            <div class="login_form-input">
                <input type="email" name="email" value="{{ old('email') }}" placehold="メールアドレス">
            </div>
            <div class="login_form-input">
                <input type="password" name="password" placehold="パスワード">
            </div>
            <div class="login_form-button">
                <button class="login_form-button-submit">ログイン</button>
            </div>
        </form>
        <div class="login_link">
            <p class="login_link-text">アカウントお持ちでないの方はこちら</p>
            <a href="/register" class="login_link">会員登録</a>
        </div>
    </div>
</div>
@endsection