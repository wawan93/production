@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Заказ команды #{{ $order->team_id }} ({{ $order->team()->region_name }} {{ $order->team()->district_number }})</div>
                    <div class="panel-body">
                        <a href="{{ url('/order') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="col-md-offset-4 col-md-8">
                        @foreach($order->team()->members() as $user)
                            <p>{{ $user->surname }} {{ $user->name }} {{ $user->middlename }} (#{{ $user->id }})</p>
                        @endforeach

                        <h3>Заказ: {{ $order->code_name }}</h3>
                        <p><strong>{!! $order->type()->mat_name !!}, Изначальный тираж: {{ $order->edition_initial }}</strong></p>
                        <p>{!! nl2br($order->type()->mat_descr) !!}</p>

                            @if($order->manufacturer)
                                @if($order->mail_sent)
                                    <p><strong>Письмо отправлено</strong></p>
                                @else
                                    {!! Form::model($order, [
                                        'method' => 'POST',
                                        'url' => ['/sendMail', $order->id],
                                        'class' => 'form-horizontal',
                                        'files' => true
                                    ]) !!}
                                    <p>
                                    {!! Form::submit('Написать письмо', ['class' => 'btn btn-primary']) !!}
                                    </p>
                                    {!! Form::close() !!}
                                @endif
                            @endif
                        </div>
                        <br>

                        {!! Form::model($order, [
                            'method' => 'PATCH',
                            'url' => ['/order', $order->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('order.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
