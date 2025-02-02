<div class="form-group {{ $errors->has('short_name') ? 'has-error' : ''}}">
    {!! Form::label('short_name', 'Short Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('short_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('short_name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('full_name') ? 'has-error' : ''}}">
    {!! Form::label('full_name', 'Полное название', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('full_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('full_name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('full_name_decl') ? 'has-error' : ''}}">
    {!! Form::label('full_name_decl', 'Склоненное название', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('full_name_decl', null, ['class' => 'form-control']) !!}
        {!! $errors->first('full_name_decl', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('inn') ? 'has-error' : ''}}">
    {!! Form::label('inn', 'ИНН', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('inn', null, ['class' => 'form-control']) !!}
        {!! $errors->first('inn', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('domicile') ? 'has-error' : ''}}">
    {!! Form::label('domicile', 'Адрес для выходных данных', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('domicile', null, ['class' => 'form-control']) !!}
        {!! $errors->first('domicile', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('domicile') ? 'has-error' : ''}}">
    {!! Form::label('full_address', 'Полный юридический адрес', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('full_address', null, ['class' => 'form-control']) !!}
        {!! $errors->first('full_address', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('contact') ? 'has-error' : ''}}">
    {!! Form::label('contact', 'Contact', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('contact', null, ['class' => 'form-control']) !!}
        {!! $errors->first('contact', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'НЕ показывать для районов', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select(
            'restricted[]',
            \App\RegionNames::forSelect(),
            null,
            ['multiple','class' => 'form-control', 'style' => 'height: 400px;']
        ) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
