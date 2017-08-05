@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Manufacturer {{ $manufacturer->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/manufacturer') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/manufacturer/' . $manufacturer->id . '/edit') }}" title="Edit Manufacturer"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['manufacturer', $manufacturer->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Manufacturer',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $manufacturer->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Короткое название </th>
                                        <td> {{ $manufacturer->short_name }} </td>
                                    </tr>
                                    <tr>
                                        <th> Полное название </th>
                                        <td> {{ $manufacturer->full_name }} </td>
                                    </tr>
                                    <tr>
                                        <th> Склоненное название </th>
                                        <td> {{ $manufacturer->full_name_decl }} </td>
                                    </tr>
                                    <tr>
                                        <th> ИНН </th>
                                        <td> {{ $manufacturer->contact }} </td>
                                    </tr>
                                    <tr>
                                        <th> Юридический адрес </th>
                                        <td> {{ $manufacturer->domicile }} </td>
                                    </tr>
                                    <tr>
                                        <th> Email </th>
                                        <td> {{ $manufacturer->email }} </td>
                                    </tr>
                                    <tr>
                                        <th> Контакт </th>
                                        <td> {{ $manufacturer->contact }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
