@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Заказ команды #{{ $order->team_id }} ({{ $order->team()->region_name }} {{ $order->team()->district_number }})
                        <strong>{{ $order->team()->diplomat() }} </strong>
                        @if($order->alert)
                            <strong><span class="actualize_required">ТРЕБУЕТСЯ АКТУАЛИЗАЦИЯ!</span></strong> <button class="btn btn-xs btn-danger its-ok">Всё ок</button>
                        @endif
                    </div>
                    <div class="panel-body">
                        <div class="row">
                        <div class="col-md-4">
                            <a href="{{ url('/order') }}" title="Back"><button class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                            <br />
                            <br />
                            {!! Form::open([
                                'method'=>'DELETE',
                                'url' => ['order', $order->id],
                                'style' => 'display:inline'
                            ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Delete order',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                            {!! Form::close() !!}


                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="col-md-8">
                            @if($order->alert)
                                <?php
                                $districtMembers = \App\User::whereIn('role', ['candidate', 'coordinator'])
                                    ->where([
                                        'region_name' => $order->team()->region_name,
                                        'district' => $order->team()->district_number,
                                    ])
                                    ->get();
                                $orderMembers = collect($order->polygraphy_approved()->members());
                                $diff = $districtMembers->diff($orderMembers);
                                ?>
                                @if ($diff->count() > 0)
                                    {!! Form::open(['class' => 'col-md-6 row']) !!}
                                        <div class="input-group">
                                            {!! Form::select('new_members', $diff->pluck('surname', 'id'), null, ['class' => 'form-control user-id']) !!}
                                            <span class="input-group-btn">
                                                {!! Form::submit('Добавить в заказ', ['class' => 'btn btn-success add-to-order']) !!}
                                            </span>
                                        </div>
                                    {!! Form::close() !!}
                                @endif
                                <div class="clearfix"> </div>
                                <hr>
                            @endif
                            @foreach($order->members() as $user)
                                <p>
                                    {{ $user->surname }} {{ $user->name }} {{ $user->middlename }} (#{{ $user->id }})
                                    @if($order->alert)
                                        <i class="glyphicon glyphicon-remove remove-team-member" data-id="{{ $user->id }}"> </i>
                                    @endif
                                </p>
                            @endforeach

                            <h3>Заказ: {{ $order->code_name }}</h3>
                            <p><strong>{!! $order->type()->mat_name !!}, Изначальный тираж: {{ $order->edition_initial }}</strong></p>
                            <p>{!! nl2br($order->type()->mat_descr) !!}</p>

                            <p><a href="{{ url('http://mundep.gudkov.ru/fundraising/team/' . $order->team_id) }}" target="_blank" class="btn btn-default">страница фандрайзинга</a></p>


                            @if($order->manufacturer)
                                @if($order->mail_sent)
                                    <p><strong>Письмо отправлено</strong></p>
                                @endif
                                <p><a href="/viewMail/{{ $order->id }}" class="btn btn-primary">Написать в типографию</a></p>
                            @endif

                        </div>

                        </div>
                        <hr>

                        {!! Form::model($order, [
                            'method' => 'PATCH',
                            'url' => ['/order', $order->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('order.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                        <hr>

                        <div class="form-horizontal">
                            <div class="form-group {{ $errors->has('invoice_subject') ? 'has-error' : ''}}">
                                {!! Form::label('invoice_subject', 'Счёт', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6 invoices">
                                    @foreach($order->members() as $user)
                                        <?php $invoice = $order->invoices()->where('user_id', $user->id)->first() ?>
                                        @if($invoice)
                                            <p><strong>{{ $user->surname }} {{  $user->name }}</strong></p>
                                            <p>
                                                <a target="_blank" class="btn btn-default" href="https://dmachine.gudkov.ru/chainsigns/ajax/ajax_ext_attach.php?context=previewSignchain&download_hash_md5={{$invoice->download_hash_md5}}">
                                                    Счёт (загружен {{ $invoice->timeAgo }} назад)
                                                </a>
                                                <a class="btn btn-danger delete-invoice" data-id="{{ $invoice->id }}">Удалить счёт</a>
                                            </p>
                                                <?php $payment = $order->payments()->where('user_id', $user->id)->first() ?>
                                                @if($payment)
                                                    <p>
                                                    <a target="_blank" class="btn btn-default" href="https://dmachine.gudkov.ru/chainsigns/ajax/ajax_ext_attach.php?context=previewSignchain&download_hash_md5={{$payment->download_hash_md5}}">
                                                        Платёжка (загружен {{ $payment->timeAgo }} назад)
                                                    </a>
                                                    <a class="btn btn-danger delete-payment" data-id="{{ $payment->id }}">Удалить платёжку</a>
                                                    </p>
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

                        <hr>

                        <div class="form-horizontal">
                            <div class="form-group {{ $errors->has('invoice_subject') ? 'has-error' : ''}}">
                                {!! Form::label('invoice_subject', 'Ссылка на макет', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    @if(!empty($order->maket_url))
                                        <p><a href="{{ $order->maket_url }}" target="_blank" class="">{{ $order->maket_url }}</a></p>
                                        @if($order->maket_ok)
                                            <p><strong>✅ утверждён цензором</strong></p>
                                        @elseif(strpos(Auth::user()->extra_class, 'c_maket_approve') !== false)
                                            <p><a href="#" class="btn btn-danger approve-maket">Утвердить</a></p>
                                        @else
                                            <p><strong>❌ пока не утверждён цензором</strong></p>
                                        @endif

                                        @if($order->polygraphy_approved()->maket_agree_with === 'true')
                                            <p><strong>✅ все кандидаты ознакомились с макетом</strong></p>
                                        @else
                                            <p><strong>пока не все видели макет</strong></p>
                                        @endif

                                        @if ($order->needCorrections())
                                            @if($order->maket_ok_final)
                                                <p><strong>✅ правочки утверждены</strong></p>
                                            @elseif(strpos(Auth::user()->extra_class, 'c_maket_corrections_approve') !== false)
                                                <p><a href="#" class="btn btn-danger approve-maket-corrections">Утвердить последние правочки</a></p>
                                            @else
                                                <p><strong>❌ пока не утверждёны все правки</strong></p>
                                            @endif
                                        @else
                                            <p><strong>✅ правок не было</strong></p>
                                        @endif
                                    @else
                                        <p>нет макета</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('styles')
        <style>
            .actualize_required {
                color: #bf5329;
            }
            .remove-team-member {
                color: #bf5329;
                cursor: pointer;
            }
        </style>
    @endsection

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

                        smartAjax('/ajax/save_invoice', {
                            data: JSON.stringify(data),
                            user_id: fileUploader.container.attr('data-user'),
                            order_id: fileUploader.container.attr('data-order'),
                        }, function(msg){

                            location.reload();

                        }, function(msg){
                            alert(msg.error_text);
                        });

                    };
                    fileUploader.initListener();
                    fileUploader.setOriginMode('laravel');

                    $('.approve-maket').on('click', function() {
                        if (confirm('утвердить макет?')) {
                            var _this = $(this);
                            smartAjax('/ajax/approve_maket', {
                                order_id: '{{ $order->id }}',
                            }, function(msg) {
                                location.reload();
                            }, function(msg) {
                                alert(msg.error_text);
                            }, 'approve-maket', 'POST');
                        }
                    });

                    $('.approve-maket-corrections').on('click', function() {
                        if (confirm('утвердить правки по макету?')) {
                            var _this = $(this);
                            smartAjax('/ajax/approve_maket_corrections', {
                                order_id: '{{ $order->id }}',
                            }, function(msg) {
                                location.reload();
                            }, function(msg) {
                                alert(msg.error_text);
                            }, 'approve-maket', 'POST');
                        }
                    });

                    $('.invoices').on('click', '.delete-invoice', function(e) {
                        if (confirm('Удалить счёт?')) {
                            smartAjax('/ajax/delete/invoice', {
                                id: $(this).data('id'),
                            }, function(msg){
                                location.reload();
                            }, function(msg){
                                alert(msg.error_text);
                            }, 'delete_invoice', 'DELETE');
                        }
                        return false;
                    });

                    $('.invoices').on('click', '.delete-payment', function(e) {
                        if (confirm('Удалить платёжку?')) {
                            smartAjax('/ajax/delete/payment', {
                                id: $(this).data('id'),
                            }, function(msg) {
                                location.reload();
                            }, function(msg) {
                                alert(msg.error_text);
                            }, 'delete_payment', 'DELETE');
                        }
                        return false;
                    });

                    $('.panel-heading').on('click', '.achtung', function(e) {
                        smartAjax('/ajax/achtung', {
                            id: $(this).data('id'),
                            status: $(this).data('status')
                        }, function(msg) {
                            location.reload();
                        }, function(msg) {
                            alert(msg.error_text);
                        }, 'achtung', 'POST');
                        return false;
                    });

                    $('.remove-team-member').on('click', function(e) {
                        if (confirm('Убрать кандидата из заказа?')) {
                            smartAjax('/ajax/remove_team_member', {
                                order_id: {{ $order->id }},
                                user_id: $(this).data('id')
                            }, function(msg){
                                console.log('Удален юзер ' + $(this).data('id'))
                                location.reload();
                            }, function(msg){
                                alert(msg.error_text);
                            }, '', 'POST');
                        }
                    });

                    $('.its-ok').on('click', function(e) {
                        if (confirm('Порешали вопросики?')) {
                            smartAjax('/ajax/its_ok', {
                            	order_id: {{ $order->id }},
                            }, function(msg){
                            	console.log('it\'s ok!');
                            	location.reload();
                            }, function(msg){
                            	alert(msg.error_text);
                            });
                        }
                    });

                    $('.add-to-order').on('click', function(e) {
                        var user = $(this).closest('.input-group').find('.user-id').val();
                        smartAjax('/ajax/add_to_order', {
                            order_id: {{ $order->id }},
                            user_id: user,
                        }, function(msg){
                            location.reload();
                        }, function(msg){
                            alert(msg.error_text);
                        }, '', 'POST');

                        return false;
                    });
                });
            })($ || jQuery);
        </script>
    @endsection
@endsection
