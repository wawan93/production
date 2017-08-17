@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="flow-table">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Выполненные заказы
                        <button class="btn btn-sm btn-primary excel">Скачать в Excel</button>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            {!! Form::open(['id' => 'filter-form', 'action' => 'OrderController@delivered', 'method' => 'GET']) !!}
                            {!! Form::close() !!}
                            <table class="table table-borderless table-striped table-hover sorting tablesorter" id="exportableTable">
                                <thead>
                                    <tr>
                                        <th class="header">Изготовитель</th>
                                        <th class="header">Район</th>
                                        <th class="header">Дата доставки</th>
                                        <th class="header">Тираж</th>
                                        <th class="header">Кандидаты</th>
                                    </tr>

                                    <tr>
                                        <td>{!! Form::select('manufacturer', \App\Manufacturer::forSelect(), null, ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td name="Изготовитель">
                                            {{ $order->manufacturer()->short_name }}
                                        </td>
                                        <td name="Район">{{ $order->team()->region_name }} (Округ {{ $order->team()->district_number }})</td>
                                        <td name="Дата доставки">
                                            {{ $order->receive_time ?: $order->ship_date . ' ' .$order->ship_time }}
                                        </td>
                                        <td name="Тираж">
                                            {{ $order->edition_final }}
                                        </td>
                                        <td name="Кандидаты">
                                            @foreach($order->team()->members() as $user)
                                                <p>
                                                {{ $user->surname }} {{ $user->name }} {{ $user->middlename }}
                                                (#{{ $user->id }})
                                                </p>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="/js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript">
        (function($) {
            $(document).ready(function(){
                $('.filter').on('change', function (e) {

                    console.log($('#filter-form').submit());
                });

                $('.tablesorter').tablesorter();

                $('.excel').on('click', function(e) {
                    var _this = $(this);
                    var filename = 'Готовые заказы.xls';

                    tableToExcel('exportableTable', 'W3C Example Table', filename);

                })
            });
        })($ || jQuery);
    </script>
@endsection