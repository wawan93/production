@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Order</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Район</th>
                                        <th>Округ</th>
                                        <th>Заказ</th>
                                        <th>Менеджер</th>
                                        <th>Лампочка</th>
                                        <th>Статус</th>
                                        <th>Тираж из квеста</th>
                                        <th>Тираж финальный</th>
                                        <th>Изготовитель</th>
                                        <th>Дата оплаты</th>
                                        <th>Дата выхода</th>
                                        <th>Дата доставки</th>
                                        <th>Контакт</th>
                                    </tr>
                                    <tr>
                                        <th>{!! Form::select('region_name', \App\RegionNames::forSelect(), @$filter['region_name'], ['class' => 'form-control']) !!}</th>
                                        <th><input type="text" class="form-control"/></th>
                                        <th><input type="text" class="form-control"/></th>
                                        <th><input type="text" class="form-control"/></th>
                                        <th><input type="text" class="form-control"/></th>
                                        <th><input type="text" class="form-control"/></th>
                                        <th><input type="text" class="form-control"/></th>
                                        <th><input type="text" class="form-control"/></th>
                                        <th><input type="text" class="form-control"/></th>
                                        <th><input type="text" class="form-control"/></th>
                                        <th><input type="text" class="form-control"/></th>
                                        <th><input type="text" class="form-control"/></th>
                                        <th><input type="text" class="form-control"/></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($order as $item)
                                    <tr onclick="document.location = '{{ url('/order/' . $item->id . '/edit') }}';">
                                        <td>{{ $item->team()->region_name }}</td>
                                        <td>{{ $item->team()->district_number }}</td>
                                        <td>{{ $item->code_name }}</td>
                                        <td>{{ $item->manager()->name . ' ' . $item->manager()->surname }}</td>
                                        <td>{{ $item->alert ? 'Да' : 'Нет' }}</td>
                                        <td>{{ $item->getStatus() }}</td>
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
                            <div class="pagination-wrapper"> {!! $order->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
