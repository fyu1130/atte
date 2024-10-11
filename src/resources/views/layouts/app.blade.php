<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                Atte
            </div>

            @if(Auth::check())
                <div class="header__nav">
                    <a href="/" class="header__nav--link">ホーム</a>
                    <a href="/all_users" class="header__nav--link">ユーザ一覧</a>
                    <a href="/date_attendance" class="header__nav--link">日付一覧</a>
                    <form action="/logout" method="post">
                        @csrf
                        <button class="header__nav--item">ログアウト</button>
                    </form>
                </div>
            @endif

        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="footer">
        <div class="footer__inner">
            <p class="footer__logo">
                Atte.inc.
            </p>
        </div>
    </footer>
    
</body>
</html>