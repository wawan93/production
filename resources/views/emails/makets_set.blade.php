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
            <p>
                <strong>Заказ {{ $order->polygraphy_format }} {{ $order->edition_final }}шт. {{ $order->code_name }}</strong>
                - <a href="{{ $order->maket_url }}" target="_blank">{{ $order->maket_url }}</a>
                {{ $order->maket_ok ? '✅' : '' }}
                {{ $order->polygraphy_approved()->maket_agree_with === 'true' ? '✅' : '' }}
                @if ($order->needCorrections())
                    {{ $order->maket_ok_final ? '✅' : '' }}
                @else
                    ✅
                @endif
            </p>
        @endforeach
        <p>{!! nl2br($signature) !!}</p>
    </body>
</html>