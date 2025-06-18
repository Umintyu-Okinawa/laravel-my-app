<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width-with,initial-scale=1,0">
        <title>お問い合わせ</title>
    </head>
    <body>
        <h1>{{$role === 'admin' ? 'お問い合わせ' : 'お問い合わせ内容' }}</h1>



        <p><strong>お名前</strong>{{$contact['name']}}</p>
        <p><strong>メールアドレス</strong>{{$contact['email']}}</p>
        <p><strong>メッセージ</strong>{{$contact['message']}}</p>

        </body>
</html>