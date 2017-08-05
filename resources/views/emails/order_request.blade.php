<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>{{  }}</title>
    </head>

    <body>
        <p>Здравствуйте, пожалуйста, примите в работу заказ и подготовьте счета для кандидатов.</p>
        @foreach($order->team()->members() as $user)
            {{ $user->surname }}
        @endforeach
    </body>
</html>

