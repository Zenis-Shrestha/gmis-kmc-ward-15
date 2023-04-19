@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="{{ action('AddZoneController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
        @ability('super-admin', 'add-add-zones')
            <a href="{{ action('AddZoneController@add') }}" class="btn btn-info">{{ __('Add new Address Zone') }}</a>
        @endability
    </div>
    <div class="form-horizontal">
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('addrzn', __('Short Name'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $addZone->addrzn, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('value', __('Numeric Value'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $addZone->value, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('name', __('Full Name'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $addZone->name, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
