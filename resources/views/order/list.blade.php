@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @if (count($orders) > 0)
                    <div class="panel panel-default">
                        <div class="panel-heading">

                        </div>

                        <div class="panel-body">
                            <table class="table table-striped task-table">
                                <thead>
                                <td>Район</td>
                                <td>Округ</td>
                                <td>Заказ</td>
                                <td>Менеджер</td>
                                <td>Лампочка</td>
                                <td>Тираж из квеста</td>
                                <td>Статус</td>
                                <td>Тираж финал.</td>
                                <td>Изготовитель</td>
                                <td>Дата оплаты из квеста</td>
                                <td>Дата выхода</td>
                                <td>Дата доставки</td>
                                <td>Время доставки</td>
                                <td>Контакт</td>
                                </thead>

                                <tbody>
                                @each('order.list_item', $vacancies, 'vacancy')
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection