@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Order</div>
                    <div class="panel-body">
                        <a href="{{ url('/order/create') }}" class="btn btn-success btn-sm" title="Add New order">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/order', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
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
                                        <th>actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($order as $item)
                                    <tr>
                                        <td>{{ $item->team()->region_name }}</td>
                                        <td>{{ $item->team()->district_number }}</td>
                                        <td>{{ $item->code_name }}</td>
                                        <td>{{ $item->manager()->name . ' ' . $item->manager()->surname }}</td>
                                        <td>{{ $item->alert ? 'Да' : 'Нет' }}</td>
                                        <td>{{ $item->getStatus() }}</td>
                                        <td>{{ $item->edition_initial }}</td>
                                        <td>{{ $item->edition_final }}</td>
                                        <td>{{ $item->manufacturer }}</td>
                                        <td>{{ $item->paid_date }}</td>
                                        <td>{{ $item->final_date }}</td>
                                        <td>{{ $item->ship_date }}</td>
                                        <td>{{ $item->contact }}</td>
                                        <td>
                                            <a href="{{ url('/order/' . $item->id . '/edit') }}" title="Edit order"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
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
@endsection
