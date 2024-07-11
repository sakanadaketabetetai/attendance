<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <title>Atte</title>
</head>
<body>
    <header>
        <div>
            <div class="header_logo">
                <h1>Atte</h1>
            </div>
            <div class="header_nav">
                <nav>
                    <ul>
                        @if(Auth::check())
                        <li>
                            <a href="/" class="header_nav-text">ホーム</a>
                        </li>
                        <li>
                            <a href="{{ route('attendance.filter') }}" class="header_nav-text">日付一覧
                            </a>
                        </li>
                        <li>
                            <form action="/logout" method="post">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <div class="content">
            @yield('content')
        </div>
    </main>
</body>
</html>