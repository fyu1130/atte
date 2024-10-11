<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/varify-email.css')}}">
</head>

<body>
<main>
    <div class="container">
        <h1>メール認証</h1>
        <p>登録時に入力したメールアドレスに確認リンクを送信しました。</p>
        <p>メールが届いているか確認し、認証を完了してください。</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">確認メールを再送信</button>
        </form>
        <form action="/logout" method="post">
            @csrf
            <button class="header__nav--item">ログアウト</button>
        </form>
    </div>
</main>
</body>

</html>