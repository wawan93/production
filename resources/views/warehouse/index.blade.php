@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="flow-table">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Заказы (Всего {{ $count }})</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            {!! Form::open(['id' => 'filter-form', 'action' => 'WarehouseController@index', 'method' => 'GET']) !!}
                            {!! Form::close() !!}
                            <table class="table table-borderless table-striped table-hover sorting tablesorter">

                                <thead>
                                    <tr class="sorting">
                                        <th data-direction="asc" data-field="code_name">Заказ</th>
                                        <th data-direction="asc" data-field="status">Статус</th>
                                        <th data-direction="asc" data-field="edition_final">Тираж</th>
                                        <th data-direction="asc" data-field="manufacturer">Изготовитель</th>
                                        <th data-direction="asc" data-field="ship_date">Доставка</th>
                                        <th data-direction="asc" data-field="contact">Контакт</th>
                                        <th data-direction="asc" data-field="received">Получен</th>
                                        <th data-direction="asc" data-field="delivery">Разнос</th>
                                        <th data-direction="asc" data-field="sorted">Сортировка</th>
                                        <th data-direction="asc" data-field="commentDelivery">Коммент</th>
                                        <th data-direction="asc" data-field="docs">Документы</th>
                                        <th data-direction="asc" data-field="docs_comment">Коммент по докам</th>
                                        <th data-direction="asc" data-field="docs_in_shtab">Документы в штабе</th>
                                        <th data-direction="asc" data-field="delivery_count">Кол-во на разнос</th>
                                    </tr>
                                    <tr>
                                        <td>{!! Form::text('filter[code_name]',  @$filter['code_name'],['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td>{!! Form::select('filter[status]', \App\Order::allStatuses(), @$filter['status'], ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td></td>
                                        <td>{!! Form::select('filter[manufacturer]', \App\Manufacturer::forSelect(), null, ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td>{!! Form::date('filter[ship_date]', null, ['class' => 'form-control filter', 'style'=>'width:100px;', 'form' => 'filter-form']) !!}</td>
                                        <td></td>
                                        <td>{!! Form::checkbox('filter[received]',  @$filter['received'], @$filter['received'], ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td>{!! Form::checkbox('filter[delivery]',  @$filter['delivery'], @$filter['delivery'], ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td>{!! Form::checkbox('filter[sorted]',  @$filter['delivered'], @$filter['delivered'], ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td></td>
                                        <td>{!! Form::checkbox('filter[docs]',  @$filter['docs'], @$filter['docs'], ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td></td>
                                        <td>{!! Form::checkbox('filter[docs_in_shtab]',  @$filter['docs_in_shtab'], @$filter['docs_in_shtab'], ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td>{!! Form::number('filter[delivery_count]',  @$filter['delivery_count'], @$filter['delivery_count'], ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($order as $item)
                                    <tr>
                                        <td>
                                            {{ $item->code_name }}
                                        </td>
                                        <td>
                                            {{ $item->getStatus() }}
                                        </td>
                                        <td>{{ $item->edition_final }}</td>
                                        <td>
                                            {{ $item->manufacturer() ? $item->manufacturer()->short_name : '' }}
                                        </td>
                                        <td>{{ $item->ship_date ? date('d.m.Y', strtotime($item->ship_date)) : '' }}
                                            {{ $item->ship_time ? date('H:i', strtotime($item->ship_time)) : '' }}</td>
                                        <td>{{ $item->contact }}</td>

                                        <td>
                                            {!! Form::checkbox('received', $item->received, $item->received, [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->code_name,
                                                    'data-field' => 'received',
                                            ]) !!}
                                        </td>
                                        <td>
                                            {!! Form::checkbox('delivery', $item->delivery, $item->delivery, [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->code_name,
                                                    'data-field' => 'delivery',
                                            ]) !!}
                                        </td>
                                        <td>
                                        {!! Form::number('delivery_count', $item->delivery_count, $item->delivery_count, [
                                                'class' => 'form-control',
                                                'data-id' => $item->code_name,
                                                'data-field' => 'delivery_count',
                                        ]) !!}
                                        <td>
                                            {!! Form::checkbox('sorted', $item->sorted, $item->sorted, [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->code_name,
                                                    'data-field' => 'sorted',
                                            ]) !!}
                                        </td>
                                        <td>
                                            {!! Form::textarea(
                                                'commentDelivery',
                                                $item->commentDelivery,
                                                [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->code_name,
                                                    'data-field' => 'commentDelivery',
                                                ]
                                            ) !!}
                                        </td>
                                        <td>
                                            {!! Form::checkbox('docs', $item->docs, $item->docs, [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->code_name,
                                                    'data-field' => 'docs',
                                            ]) !!}
                                        </td>
                                        <td>
                                            {!! Form::textarea(
                                                'comment_docs',
                                                $item->commentDocs,
                                                [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->code_name,
                                                    'data-field' => 'comment_docs',
                                                ]
                                            ) !!}
                                        </td>
                                        <td>
                                            {!! Form::checkbox('docs_in_shtab', $item->docs_in_shtab, $item->docs_in_shtab, [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->code_name,
                                                    'data-field' => 'docs_in_shtab',
                                            ]) !!}
                                        </td>
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

                var update = function(_this) {
                    var code_name = _this.data('id');
                    var field = _this.data('field');
                    var value = _this.val();
                    if (_this.attr('type') == 'checkbox') {
                        value = _this.prop('checked');
                    }

                    smartAjax('/ajax/save_order', {
                        code_name: code_name,
                        field: field,
                        value: value,
                    }, function(msg) {
                        console.log(msg);
                    }, function(msg) {
                        console.log(msg.error_text);
                    }, 'order_flow', 'POST');
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
                        update(_this);
                    });
                });
            })($ || jQuery);
        </script>
    @endsection

    @section('styles')
        <style>
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
