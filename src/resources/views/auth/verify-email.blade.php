@extends('layouts.app')

@section('css')
@endsection

@section('content')
<h1>Verify Your Email Address</h1>

    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif

    <p>登録したメールアドレスに確認メールを送信しました。受信後確認ボタンを押してください。</p>
    <p>メールが届かない場合は以下をクリックすると、確認メールが再送されます。</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">確認メールを再送する</button>
    </form>
@endsection