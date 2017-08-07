<div class="form-group {{ $errors->has('manager_id') ? 'has-error' : ''}}">
    {!! Form::label('manager_id', 'Менеджер', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('manager_id', \App\User::managers(), null, ['class' => 'form-control']) !!}
        {!! $errors->first('manager_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Статус', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('status', [
            'approved' => 'Согласован',
            'invoices' => 'Выставлены счета',
            'paid' => 'Оплачено',
            'production' => 'В производстве',
            'shipped' => 'Доставлено'
        ], null, ['class' => 'form-control']) !!}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('edition_final') ? 'has-error' : ''}}">
    {!! Form::label('edition_final', 'Тираж финальный', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('edition_final', null, ['class' => 'form-control']) !!}
        {!! $errors->first('edition_final', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('manufacturer') ? 'has-error' : ''}}">
    {!! Form::label('manufacturer', 'Изготовитель', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('manufacturer', \App\Manufacturer::forSelect(), null, ['class' => 'form-control']) !!}
        {!! $errors->first('manufacturer', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('paid_date') ? 'has-error' : ''}}">
    {!! Form::label('paid_date', 'Дата оплаты', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('paid_date', null, ['class' => 'form-control']) !!}
        {!! $errors->first('paid_date', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('final_date') ? 'has-error' : ''}}">
    {!! Form::label('final_date', 'Дата выхода', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('final_date', null, ['class' => 'form-control', 'pattern'=>"[0-9]{4}-[0-9]{2}-[0-9]{2}"]) !!}
        {!! $errors->first('final_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('ship_date') ? 'has-error' : ''}}">
    {!! Form::label('ship_date', 'Дата доставки', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('ship_date', $order->ship_date, ['class' => 'form-control']) !!}
        {!! $errors->first('ship_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('ship_date') ? 'has-error' : ''}}">
    {!! Form::label('ship_date', 'Время доставки', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::time('ship_time', $order->ship_time, ['class' => 'form-control']) !!}
        {!! $errors->first('ship_time', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('contact') ? 'has-error' : ''}}">
    {!! Form::label('contact', 'Контакт доставки', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('contact', null, ['class' => 'form-control']) !!}
        {!! $errors->first('contact', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('invoice_subject') ? 'has-error' : ''}}">
    {!! Form::label('invoice_subject', 'Предмет счёта', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('invoice_subject', null, ['class' => 'form-control']) !!}
        {!! $errors->first('invoice_subject', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
