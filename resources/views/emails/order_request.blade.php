<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Заказ {{ $order->invoice_subject }}</title>
    </head>

    <body>
        <p>{!! nl2br($intro) !!}</p>
        @foreach($order->team()->members() as $user)
            <p><strong>Кандидат {{ $user->surname }} {{ $user->name }} {{ $user->middlename }}</strong></p>
            <p><em>В счёте-договоре в поле Заказчик нужно написать</em></p>
            <p>
                Кандидат в депутаты {{ $user->election }} по многомандатному избирательному округу № {{ $user->district }}
                {{ $user->surname }} {{ $user->name }} {{ $user->middlename }}
            </p>
            <p><em>В предмете счёта-договора нужно написать</em></p>
            <table border="1">
                <thead>
                <tr>
                    <th>№</th><th>Товары (работы, услуги)</th><th>Кол-во</th><th>Ед.</th><th>Цена</th><th>Сумма</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $order->invoice_subject }}</td>
                    <td>{{ floor($order->edition_final / count($order->team()->members())) }}</td>
                    <td>шт.</td>
                    <td>&lt;цена за единицу&gt;;</td>
                    <td>&lt;сумма заказа&gt;</td>
                </tr>
                </tbody>
            </table>
        @endforeach
        <p>{!! nl2br($signature) !!}</p>
    </body>
</html>

