<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
    {!! Form::label('type', 'Type', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('type', null, ['class' => 'form-control']) !!}
        {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('format') ? 'has-error' : ''}}">
    {!! Form::label('format', 'Format', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('format', null, ['class' => 'form-control']) !!}
        {!! $errors->first('format', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('mat_name') ? 'has-error' : ''}}">
    {!! Form::label('mat_name', 'Mat Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('mat_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('mat_name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('mat_descr') ? 'has-error' : ''}}">
    {!! Form::label('mat_descr', 'Mat Descr', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('mat_descr', null, ['class' => 'form-control']) !!}
        {!! $errors->first('mat_descr', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('order_code') ? 'has-error' : ''}}">
    {!! Form::label('order_code', 'Order Code', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('order_code', null, ['class' => 'form-control']) !!}
        {!! $errors->first('order_code', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('mat_type') ? 'has-error' : ''}}">
    {!! Form::label('mat_type', 'Mat Type', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('mat_type', null, ['class' => 'form-control']) !!}
        {!! $errors->first('mat_type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
