<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <title>Atte</title>
</head>
<body>
    <header class="header">
        <div class="header_inner">
            <div class="header-utilities">
                <a href="/" class="header_logo">Atte</a>
                <div class="header-nav">
                    @if(Auth::check())
                    <div class="header-nav_item">
                        <a href="/" class="header-nav_link">ホーム</a>
                    </div>
                    <div class="header-nav_item">
                        <a href="{{ route('attendance') }}" class="header-nav_link">日付一覧
                        </a>
                    </div>
                    <div class="header-nav_item">
                        <form action="/logout" method="post">
                            @csrf
                            <button class="header-nav_button">ログアウト</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="content">
            @yield('content')
        </div>
    </main>
    <footer>
        <div class="footer_content">
            <small>Atte,inc.</small>
        </div>
    </footer>
</body>
</html>