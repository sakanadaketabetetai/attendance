@extends('layouts.app')

@section('css')

@endsection

@section('content')

<div class="register_content">
    <div class="register_title">
        <h2>会員登録</h2>
    </div>
    <div class="register_form">
        <form action="/register" method="post">
            @csrf
            <div class="register_form-input">
                <input type="text" name="name" value="{{ old('name') }}" placeholder="名前">
            </div>
            <div class="register_form-input">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス">
            </div>
            <div class="register_form-input">
                <input type="password" name="password" placeholder="パスワード">
            </div>
            <div class="register_form-input">
                <input type="password" name="password_confirmation" placeholder="確認用パスワード">
            </div>
            <div class="register_form-button">
                <button class="register_form-button-submit">会員登録</button>
            </div>
        </form>
        <div class="register_link">
            <p class="register_link-text">アカウントお持ちの方はこちら</p>
            <a href="/login" class="register_link">ログイン</a>
        </div>
    </div>
</div>
@endsection