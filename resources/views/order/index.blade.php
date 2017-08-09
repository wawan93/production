@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Заказы (Всего {{ $count }})</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            {!! Form::open(['id' => 'filter-form', 'action' => 'OrderController@index', 'method' => 'GET']) !!}
                            <table class="table table-borderless table-striped table-hover sorting tablesorter">

                                <thead>
                                    <tr class="">
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
                                    </tr>
                                    <tr>
                                        <td>{!! Form::text('filter[code_name]',  @$filter['code_name'],['class' => 'form-control filter']) !!}</td>
                                        <td>{!! Form::select('filter[manager]', \App\User::managers(), @$filter['manager'], ['class' => 'form-control filter']) !!}</td>
                                        <td>{!! Form::select('filter[status]', \App\Order::allStatuses(), @$filter['status'], ['class' => 'form-control filter']) !!}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{!! Form::select('filter[manufacturer]', \App\Manufacturer::forSelect(), null, ['class' => 'form-control filter']) !!}</td>
                                        <td>{!! Form::date('filter[paid_date]', null, ['class' => 'form-control filter', 'style'=>'width:100px;']) !!}</td>
                                        <td>{!! Form::date('filter[final_date]', null, ['class' => 'form-control filter', 'style'=>'width:100px;']) !!}</td>
                                        <td>{!! Form::date('filter[ship_date]', null, ['class' => 'form-control filter', 'style'=>'width:100px;']) !!}</td>
                                        <td></td>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($order as $item)
                                    <tr>
                                        <td onclick="this.className=''; document.location = '{{ url('/order/' . $item->id . '/edit') }}';">{{ $item->code_name }}</td>
                                        <td>{{ $item->manager()->name . ' ' . $item->manager()->surname }}</td>
                                        <td>{{ $item->getStatus() }}</td>
                                        <td>
                                            @if ($item->status == 'fundraising_finished')
                                                {{ ($item->alert == false) ? '✅' : '🆘' }}
                                            @endif
                                        </td>
                                        <td>{{ $item->edition_initial }}</td>
                                        <td>
                                            {{ $item->edition_final }}
                                            {{--{!! Form::number(--}}
                                                {{--'edition_final',--}}
                                                {{--$item->edition_final,--}}
                                                {{--[--}}
                                                    {{--'class' => 'form-control',--}}
                                                    {{--'data-id' => $item->edition_final,--}}
                                                    {{--'data-field' => 'edition_final',--}}
                                                {{--]--}}
                                            {{--) !!}--}}
                                        </td>
                                        <td>{{ $item->manufacturer() ? $item->manufacturer()->short_name : '' }}</td>
                                        <td>{{ $item->paid_date ? date('d.m.Y', strtotime($item->paid_date)) : '' }}</td>
                                        <td>
                                            {{ $item->final_date }}
                                            {{--{!! Form::date(--}}
                                                {{--'final_date',--}}
                                                {{--$item->final_date,--}}
                                                {{--[--}}
                                                    {{--'class' => 'form-control',--}}
                                                    {{--'data-id' => $item->code_name,--}}
                                                    {{--'data-field' => 'final_date',--}}
                                                {{--]--}}
                                            {{--) !!}--}}
                                        </td>
                                        <td>
                                            {{$item->ship_date}}
                                            {{--{!! Form::date(--}}
                                                {{--'ship_date',--}}
                                                {{--$item->ship_date,--}}
                                                {{--[--}}
                                                    {{--'class' => 'form-control',--}}
                                                    {{--'data-id' => $item->code_name,--}}
                                                    {{--'data-field' => 'ship_date',--}}
                                                {{--]--}}
                                            {{--) !!}--}}
                                        </td>
                                        <td>
                                            {{ $item->ship_time}}
                                            {{--{!! Form::time(--}}
                                                {{--'ship_time',--}}
                                                {{--$item->ship_time,--}}
                                                {{--[--}}
                                                    {{--'class' => 'form-control',--}}
                                                    {{--'data-id' => $item->code_name,--}}
                                                    {{--'data-field' => 'ship_time',--}}
                                                {{--]--}}
                                            {{--) !!}--}}
                                        </td>
                                        <td>{{ $item->contact }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! Form::close() !!}
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
                    var value =  $node.find('input').val() || $node.text();
                    return value;
                };

                $(document).ready(function(){
                    $('.filter').on('change', function (e) {
                        var _this = $(this);
                        var filter = _this.attr('name').split(/.+\[(.+)\]/)[1];
                        var value = _this.val();
                        filters[filter] = value;
                        console.log($('.filter-form').submit());
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
                            alert(msg.error_text);
                        }, 'order_flow', 'POST');
                    });
                });
            })($ || jQuery);
        </script>
    @endsection
@endsection
