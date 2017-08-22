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
                                        <th data-direction="asc" data-field="responsible">ФИО кандидата</th>
                                        <th data-direction="asc" data-field="s_promised_money">согласована сумма</th>
                                        <th data-direction="asc" data-field="s_promised_money">тираж к разносу</th>
                                        <th data-direction="asc" data-field="s_comment">Коммент дипломатии</th>
                                        <th data-direction="asc" data-field="comment_delivery">Коммент</th>
                                        <th data-direction="asc" data-field="sorted">Сортировка</th>
                                        <th data-direction="asc" data-field="docs">Доки</th>
                                        <th data-direction="asc" data-field="docs_comment">Коммент по докам</th>
                                        <th data-direction="asc" data-field="docs_in_shtab">Доки в штабе</th>
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
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{!! Form::checkbox('filter[sorted]',  @$filter['delivered'], @$filter['delivered'], ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td>{!! Form::checkbox('filter[docs]',  @$filter['docs'], @$filter['docs'], ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
                                        <td></td>
                                        <td>{!! Form::checkbox('filter[docs_in_shtab]',  @$filter['docs_in_shtab'], @$filter['docs_in_shtab'], ['class' => 'form-control filter', 'form' => 'filter-form']) !!}</td>
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
                                                    'data-id' => $item->id,
                                                    'data-field' => 'received',
                                            ]) !!}
                                        </td>
                                        <td>
                                            {!! Form::checkbox('delivery', $item->delivery, $item->delivery, [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->id,
                                                    'data-field' => 'delivery',
                                            ]) !!}
                                        </td>
                                        <td>
                                            @if( $item->responsible()->first())
                                                {{ $item->responsible()->first()->surname }}
                                                {{ $item->responsible()->first()->name }}
                                                {{ $item->responsible()->first()->middlename }}
                                                {{ $item->responsible()->first()->phone }}
                                            @endif
                                        </td>
                                        <td>{{ $item->s_promised_money }}</td>
                                        <td>{{ round($item->s_promised_money / 1.7) }}</td>
                                        <td>
                                            {{ $item->s_comment }}
                                        </td>
                                        <td>
                                            {!! Form::textarea(
                                                'comment_docs',
                                                $item->commentDocs,
                                                [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->id,
                                                    'data-field' => 'comment_docs',
                                                ]
                                            ) !!}
                                        </td>
                                        <td>
                                            {!! Form::checkbox('sorted', $item->sorted, $item->sorted, [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->id,
                                                    'data-field' => 'sorted',
                                            ]) !!}
                                        </td>
                                        <td>
                                            {!! Form::checkbox('docs', $item->docs, $item->docs, [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->id,
                                                    'data-field' => 'docs',
                                            ]) !!}
                                        </td>
                                        <td>
                                            {!! Form::textarea(
                                                'comment_docs',
                                                $item->commentDocs,
                                                [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->id,
                                                    'data-field' => 'comment_docs',
                                                ]
                                            ) !!}
                                        </td>
                                        <td>
                                            {!! Form::checkbox('docs_in_shtab', $item->docs_in_shtab, $item->docs_in_shtab, [
                                                    'class' => 'form-control',
                                                    'data-id' => $item->id,
                                                    'data-field' => 'docs_in_shtab',
                                            ]) !!}
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
                    var id = _this.data('id');
                    var field = _this.data('field');
                    var value = _this.val();
                    if (_this.attr('type') == 'checkbox') {
                        value = _this.prop('checked');
                    }

                    smartAjax('/ajax/save_order', {
                        id: id,
                        field: field,
                        value: value,
                    }, function(msg) {
                        console.log(msg);
                    }, function(msg) {
                        alert(msg.error_text);
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
