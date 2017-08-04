<div class="form-group {{ $errors->has('team_id') ? 'has-error' : ''}}">
    {!! Form::label('team_id', 'Team Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('team_id', null, ['class' => 'form-control']) !!}
        {!! $errors->first('team_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('code_name') ? 'has-error' : ''}}">
    {!! Form::label('code_name', 'Code Name', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('code_name', null, ['class' => 'form-control']) !!}
        {!! $errors->first('code_name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('polygraphy_type') ? 'has-error' : ''}}">
    {!! Form::label('polygraphy_type', 'Polygraphy Type', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('polygraphy_type', null, ['class' => 'form-control']) !!}
        {!! $errors->first('polygraphy_type', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('manager_id') ? 'has-error' : ''}}">
    {!! Form::label('manager_id', 'Manager Id', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('manager_id', null, ['class' => 'form-control']) !!}
        {!! $errors->first('manager_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('alert') ? 'has-error' : ''}}">
    {!! Form::label('alert', 'Alert', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('alert', ['Да', 'Нет'], null, ['class' => 'form-control']) !!}
        {!! $errors->first('alert', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('edition_initial') ? 'has-error' : ''}}">
    {!! Form::label('edition_initial', 'Edition Initial', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('edition_initial', null, ['class' => 'form-control']) !!}
        {!! $errors->first('edition_initial', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('status', ['approved', 'invoices', 'paid', 'production', 'shipped'], null, ['class' => 'form-control']) !!}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('polygraphy_format') ? 'has-error' : ''}}">
    {!! Form::label('polygraphy_format', 'Polygraphy Format', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('polygraphy_format', ['A4', 'A3', 'vizitka', 'paper'], null, ['class' => 'form-control']) !!}
        {!! $errors->first('polygraphy_format', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('edition_final') ? 'has-error' : ''}}">
    {!! Form::label('edition_final', 'Edition Final', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('edition_final', null, ['class' => 'form-control']) !!}
        {!! $errors->first('edition_final', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('manufacturer') ? 'has-error' : ''}}">
    {!! Form::label('manufacturer', 'Manufacturer', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('manufacturer', null, ['class' => 'form-control']) !!}
        {!! $errors->first('manufacturer', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('paid_date') ? 'has-error' : ''}}">
    {!! Form::label('paid_date', 'Paid Date', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('paid_date', null, ['class' => 'form-control']) !!}
        {!! $errors->first('paid_date', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('final_date') ? 'has-error' : ''}}">
    {!! Form::label('final_date', 'Final Date', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('final_date', null, ['class' => 'form-control']) !!}
        {!! $errors->first('final_date', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('ship_date') ? 'has-error' : ''}}">
    {!! Form::label('ship_date', 'Ship Date', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::input('datetime', 'ship_date', null, ['class' => 'form-control']) !!}
        {!! $errors->first('ship_date', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('contact') ? 'has-error' : ''}}">
    {!! Form::label('contact', 'Contact', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('contact', null, ['class' => 'form-control']) !!}
        {!! $errors->first('contact', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
