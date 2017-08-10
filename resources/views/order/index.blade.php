@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="flow-table">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Заказы (Всего {{ $count }})</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            {!! Form::open(['id' => 'filter-form', 'action' => 'OrderController@index', 'method' => 'GET']) !!}
                            {!! Form::close() !!}
                            <table class="table table-borderless table-striped table-hover sorting tablesorter">

                                <thead>
                                    <tr class="sorting">
                                        <th data-direction="asc" data-field="code_name">ID</th>
                                        <th data-direction="asc" data-field="code_name">Заказ</th>
                                        <th data-direction="asc" data-field="manager_id">Менеджер</th>
                                        <th data-direction="asc" data-field="status">Статус</th>
                                        <th data-direction="asc" data-field="alert">💰</th>
                                        <th data-direction="asc" data-field="edition_initial">Тираж начальный</th>
                                        <th data-direction="asc" data-field="edition_final">Тираж финальный</th>
                                        <th data-direction="asc" data-field="manufacturer">Изготовитель</th>
                                        <th data-direction="asc" data-field="paid_date">Дата оплаты</th>
                                        <th data-direction="asc" data-field="final_date">Дата выхода</th>
                                        <th data-direction="asc" data-field="ship_date">Дата доставки</th>
                                        <th data-direction="asc" data-field="contact">Контакт</th>
                                        <th data-direction="asc" data-field="comment">Коммент</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>{!! Form::text('filter[code_name]',  @$filter['code_name'],['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td>{!! Form::select('filter[manager]', \App\User::managers(), @$filter['manager'], ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td>{!! Form::select('filter[status]', \App\Order::allStatuses(), @$filter['status'], ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{!! Form::select('filter[manufacturer]', \App\Manufacturer::forSelect(), null, ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td>{!! Form::date('filter[paid_date]', null, ['class' => 'form-control filter', 'style'=>'width:100px;', 'form' => 'filter-form']) !!}</td>
                                        <td>{!! Form::date('filter[final_date]', null, ['class' => 'form-control filter', 'style'=>'width:100px;', 'form' => 'filter-form']) !!}</td>
                                        <td>{!! Form::date('filter[ship_date]', null, ['class' => 'form-control filter', 'style'=>'width:100px;', 'form' => 'filter-form']) !!}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($order as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <a href="{{ url('/order/' . $item->id . '/edit') }}">{{ $item->code_name }}</a>
                                        </td>
                                        <td>
                                            {{ $item->manager()->name . ' ' . $item->manager()->surname }}
                                        </td>
                                        <td>
                                            {!! Form::select('status', \App\Order::allStatuses(), $item->status, [
                                                'class' => 'form-control',
                                                'data-id' => $item->code_name,
                                                'data-field' => 'status'
                                            ]) !!}
                                        </td>
                                        <td>
                                            @if ($item->status == 'fundraising_finished')
                                                {{ ($item->alert == false) ? '✅' : '🆘' }}
                                            @endif
                                        </td>
                                        <td>{{ $item->edition_initial }}</td>
                                        <td>
                                            {!! Form::number(
                                                'edition_final',
                                                $item->edition_final,
                                                [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->code_name,
                                                    'data-field' => 'edition_final',
                                                ]
                                            ) !!}
                                        </td>
                                        <td>
                                            {!! Form::select(
                                                'manufacturer',
                                                \App\Manufacturer::allowedFor($item->team()
                                                    ->region_name)->pluck('short_name', 'id')->prepend('не выбран', 0),
                                                    $item->manufacturer() ? $item->manufacturer()->id : '',
                                                [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->code_name,
                                                    'data-field' => 'edition_final',
                                                ]
                                            ) !!}

                                        </td>
                                        <td>{{ $item->paid_date ? date('d.m.Y', strtotime($item->paid_date)) : '' }}</td>
                                        <td>
                                            {!! Form::date(
                                                'final_date',
                                                $item->final_date,
                                                [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->code_name,
                                                    'data-field' => 'final_date',
                                                ]
                                            ) !!}
                                        </td>
                                        <td>
                                            {!! Form::date(
                                                'ship_date',
                                                $item->ship_date,
                                                [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->code_name,
                                                    'data-field' => 'ship_date',
                                                ]
                                            ) !!}
                                            {!! Form::time(
                                                'ship_time',
                                                $item->ship_time,
                                                [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->code_name,
                                                    'data-field' => 'ship_time',
                                                ]
                                            ) !!}
                                        </td>
                                        <td>{{ $item->contact }}</td>
                                        <td>
                                            {!! Form::textarea(
                                                'comment',
                                                $item->comment,
                                                [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->code_name,
                                                    'data-field' => 'comment',
                                                ]
                                            ) !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $order->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script type="text/javascript" src="/js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript">
            (function($) {
                var filters = {
                    'code_name': '',
                    'manager': 0,
                    'status': '',
                };

                var textExtractor = function(node) {
                    var $node = $(node);
                    var value =  $node.find('input').val() || $node.find('select').val() || $node.text();
                    return value;
                };

                $(document).ready(function(){
                    $('.filter').on('change', function (e) {
                        var _this = $(this);
                        var filter = _this.attr('name').split(/.+\[(.+)\]/)[1];
                        var value = _this.val();
                        filters[filter] = value;
                        console.log($('#filter-form').submit());
                    });

                    $('.tablesorter').tablesorter({
                        textExtraction: textExtractor
                    });

                    $('tbody').on('change', '.form-control', function() {
                        var _this = $(this);
                        var code_name = _this.data('id');
                        var field = _this.data('field');
                        var value = _this.val();

                        smartAjax('/ajax/save_order', {
                            code_name: code_name,
                            field: field,
                            value: value,
                        }, function(msg){
                            console.log(msg);
                        }, function(msg){
                            console.log(msg.error_text);
                        }, 'order_flow', 'POST');
                    });
                });
            })($ || jQuery);
        </script>
    @endsection

    @section('styles')
        <style type="text/css">
            input[type="date"].form-control {
                width: 150px;
            }
            .table>tbody>tr>td {
                padding: 2px;
                vertical-align: middle;
            }
            #flow-table .table .sorting th {
                cursor: pointer !important;
            }
            #flow-table .table td textarea {
                width: 300px;
                height: 70px;
            }
        </style>
    @endsection

@endsection
