<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Комплект заказов</title>
    </head>
    <body>
        <p>{!! nl2br($intro) !!}</p>
        @foreach($orders as $order)
            <p><strong>Заказ {{ $order->polygraphy_format }} {{ $order->edition_final }}шт. {{ $order->code_name }}</strong> - {{ $order->maket_url }}</p>
        @endforeach
        <p>{!! nl2br($signature) !!}</p>
    </body>
</html>