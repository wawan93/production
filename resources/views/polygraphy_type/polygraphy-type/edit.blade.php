@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit PolygraphyType #{{ $polygraphytype->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/polygraphy-type') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($polygraphytype, [
                            'method' => 'PATCH',
                            'url' => ['/polygraphy-type', $polygraphytype->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('polygraphy_type.polygraphy-type.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
