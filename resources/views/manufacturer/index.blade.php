@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Manufacturer</div>
                    <div class="panel-body">
                        <a href="{{ url('/manufacturer/create') }}" class="btn btn-success btn-sm" title="Add New Manufacturer">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/manufacturer', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
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
                                        <th>ID</th><th>Название</th><th>Email</th><th>Контакт</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($manufacturer as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->short_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->contact }}</td>
                                        <td>
                                            <a href="{{ url('/manufacturer/' . $item->id) }}" title="View Manufacturer"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/manufacturer/' . $item->id . '/edit') }}" title="Edit Manufacturer"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $manufacturer->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
