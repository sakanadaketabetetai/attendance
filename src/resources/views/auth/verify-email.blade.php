@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="verify-email_content">
    <div class="verify-email_title">
        <h1>Verify Your Email Address</h1>
    </div>
    <div class="verify-email_text">
        <p>登録したメールアドレスに確認メールを送信しました。受信後確認ボタンを押してください。</p>
        <p>メールが届かない場合は以下をクリックすると、確認メールが再送されます。</p>
    </div>
    
    <div class="verify-email_form-button">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="verify-email_form-button-submit">確認メールを再送する</button>
        </form>
    </div>
</div>

@endsection