@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Письмо #{{ $order->team_id }} ({{ $order->team()->region_name }} {{ $order->team()->district_number }})</div>
                    <div class="panel-body">
                        <a href="{{ action('OrderController@edit', ['id' => $order->id]) }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="col-md-offset-2 col-md-8">
                            {!! Form::model($order, [
                                'method' => 'POST',
                                'url' => ['/sendMail', $order->id],
                                'class' => 'form-horizontal',
                                'id' => 'orderMail'
                            ]) !!}

                            {!! Form::textarea(
                            'intro',
                             'Здравствуйте, пожалуйста, примите в работу заказ и подготовьте счета для кандидатов',
                             ['class'=>'form-control']
                             ) !!}

                            @include('emails.order_request', ['order' => $order, 'intro' => '', 'signature' => ''])

                            {!! Form::textarea(
                            'signature',
                             "С уважением,\nШтаб",
                             ['class'=>'form-control']
                             ) !!}

                            <p>
                                {!! Form::submit('Написать письмо', ['class' => 'btn btn-primary']) !!}
                            </p>

                            {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
