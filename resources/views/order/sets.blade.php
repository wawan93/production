@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="flow-table">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Комплекты</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            @foreach($sets as $set)
                            <p>
                                <a href="{{ url('preview-mail', ['type' => 'makets_set','id' => $set->set_id, ]) }}">
                                    Отправить комплект #{{ $set->set_id }}
                                </a>
                            </p>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
