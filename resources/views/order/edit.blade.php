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
                                    <a href="/viewMail/{{ $order->id }}">Написать письмо</a>
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

                        <div class="form-horizontal">
                            <div class="form-group {{ $errors->has('invoice_subject') ? 'has-error' : ''}}">
                                {!! Form::label('invoice_subject', 'Счёт', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    @foreach($order->team()->members() as $user)
                                        <?php $invoice = $order->invoices()->where('user_id', $user->id)->first() ?>
                                        @if($invoice)
                                            <p>
                                                <strong>{{ $user->surname }} {{  $user->name }}</strong>
                                                <a target="_blank" href="https://dmachine.gudkov.ru/chainsigns/ajax/ajax_ext_attach.php?context=previewSignchain&download_hash_md5={{$invoice->download_hash_md5}}">Счёт отправлен</a></p>
                                                <?php $payment = $order->payments()->where('user_id', $user->id)->first() ?>
                                                @if($payment)
                                                    <a target="_blank" href="https://dmachine.gudkov.ru/chainsigns/ajax/ajax_ext_attach.php?context=previewSignchain&download_hash_md5={{$payment->download_hash_md5}}">Платёжка оплачена</a></p>
                                                @endif
                                            @else
                                            {!! Form::open() !!}
                                            <label for="gdfile_upload_input"
                                                   onclick="fileUploader.initLoaderWith.apply(this, ['production_doc', fileUploader.onSuccessUploaded_question_doc]); fileUploader.container = $(this) ;"
                                                   style="background: none;padding-left: 0px;"
                                                   data-order="{{ $order->id }}"
                                                   data-user="{{ $user->id }}"
                                            >
                                                {{ $user->surname }} {{  $user->name }} <div class="btn btn-primary">Загрузить файл</div></label>
                                            {!! Form::close() !!}
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <div style="display: none;">
            <form class="FileUploadForm" enctype="multipart/form-data" method="POST" action="">
                <input id="gdfile_upload_input" type="file" name="fileupload" class="" file_callback="onSuccessUploaded_question_doc" onchange="fileUploader.beginUploadFile.apply(this, []);">
            </form>
        </div>
        <script type="text/javascript">
            (function($) {
                $(document).ready(function(){
                    fileUploader.onSuccessUploaded_question_doc = function(data){

                        console.log('Uploaded file');
                        console.log(data);

                        smartAjax('/invoice/save', {
                            data: JSON.stringify(data),
                            user_id: fileUploader.container.attr('data-user'),
                            order_id: fileUploader.container.attr('data-order'),
                        }, function(msg){

                            location.reload();

                        }, function(msg){
                            console.log(msg.error_text);
                        });

                    };
                    fileUploader.initListener();
                    fileUploader.setOriginMode('laravel');


                });
                console.log('kljasdfkjasdf');
            })($ || jQuery);
        </script>
    @endsection
@endsection
