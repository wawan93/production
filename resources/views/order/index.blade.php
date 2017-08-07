@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Заказы (Всего {{ $count }})</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            {!! Form::open(['class' => 'filter-form', 'action' => 'OrderController@index', 'method' => 'GET']) !!}
                            <table class="table table-borderless table-striped table-hover">

                                <thead>
                                    <tr>
                                        <th>Заказ</th>
                                        <th>Менеджер</th>
                                        <th>Статус</th>
                                        <th>💰</th>
                                        <th>Тираж начальный</th>
                                        <th>Тираж финальный</th>
                                        <th>Изготовитель</th>
                                        <th>Дата оплаты</th>
                                        <th>Дата выхода</th>
                                        <th>Дата доставки</th>
                                        <th>Контакт</th>
                                    </tr>
                                    <tr>
                                        <th>{!! Form::text('filter[code_name]',  @$filter['code_name'],['class' => 'form-control filter']) !!}</th>
                                        <th>{!! Form::select('filter[manager]', \App\User::managers(), @$filter['manager'], ['class' => 'form-control filter']) !!}</th>
                                        <th>{!! Form::select('filter[status]', \App\Order::allStatuses(), @$filter['status'], ['class' => 'form-control filter']) !!}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{!! Form::select('filter[manufacturer]', \App\Manufacturer::forSelect(), null, ['class' => 'form-control filter']) !!}</th>
                                        <th>{!! Form::date('filter[paid_date]', null, ['class' => 'form-control filter', 'style'=>'width:100px;']) !!}</th>
                                        <th>{!! Form::date('filter[final_date]', null, ['class' => 'form-control filter', 'style'=>'width:100px;']) !!}</th>
                                        <th>{!! Form::date('filter[ship_date]', null, ['class' => 'form-control filter', 'style'=>'width:100px;']) !!}</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($order as $item)
                                    <tr onclick="this.className=''; document.location = '{{ url('/order/' . $item->id . '/edit') }}';">
                                        <td>{{ $item->code_name }}</td>
                                        <td>{{ $item->manager()->name . ' ' . $item->manager()->surname }}</td>
                                        <td>{{ $item->getStatus() }}</td>
                                        <td>
                                            @if ($item->status == 'fundraising_finished')
                                                {{ ($item->alert == false) ? '✅' : '🆘' }}
                                            @endif
                                        </td>
                                        <td>{{ $item->edition_initial }}</td>
                                        <td>{{ $item->edition_final }}</td>
                                        <td>{{ $item->manufacturer() ? $item->manufacturer()->short_name : '' }}</td>
                                        <td>{{ $item->paid_date ? date('d.m.Y', strtotime($item->paid_date)) : '' }}</td>
                                        <td>{{ $item->final_date ? date('d.m.Y', strtotime($item->final_date)) : '' }}</td>
                                        <td>{{ $item->ship_date ? date('d.m.Y', strtotime($item->ship_date)) : '' }} {{ $item->ship_time  }}</td>
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
        <script type="text/javascript">
            (function($) {
                var filters = {
                    'code_name': '',
                    'manager': 0,
                    'status': '',
                };
                $(document).ready(function(){
                    $('.filter').on('change', function (e) {
                        var _this = $(this);
                        var filter = _this.attr('name').split(/.+\[(.+)\]/)[1];
                        var value = _this.val();
                        filters[filter] = value;
                        console.log($('.filter-form').submit());
                    });
                });
            })($ || jQuery);
        </script>
    @endsection
@endsection
