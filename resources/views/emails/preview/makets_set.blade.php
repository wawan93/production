@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Письмо в типографию о комплекте</div>
                    <div class="panel-body">

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="col-md-offset-2 col-md-8">
                            {!! Form::open([
                                'method' => 'POST',
                                'url' => [url('/send-mail', ['type' => 'makets_set', 'id' => $id], true)],
                                'class' => 'form-horizontal',
                                'id' => 'orderMail'
                            ]) !!}
                            <p>
                            {!! Form::select(
                                'manufacturer',
                                \App\Manufacturer::all()->pluck('short_name', 'id')->prepend('не выбран', 0),
                                null,
                                ['class' => 'form-control']
                            ) !!}
                            </p>
                            <p>
                            {!! $errors->first('manufacturer', '<p class="help-block">:message</p>') !!}
                            </p>
                            <p>
                            {!! Form::textarea(
                            'intro',
                             "Сформировался комплект для печати. \nВсе платёжки — в соответствующих ветках переписок. \nЗдесь  —  ссылки на макеты:",
                             ['class'=>'form-control']
                             ) !!}
                            </p>
                            @include('emails.makets_set', ['orders' => $orders, 'intro' => '', 'signature' => ''])
                            <p>
                            {!! Form::textarea(
                            'signature',
                             "Сориентируйте, пожалуйста, по дате и времени доставки этого комплекта.\n\nС уважением,\nШтаб",
                             ['class'=>'form-control']
                             ) !!}
                            </p>
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
