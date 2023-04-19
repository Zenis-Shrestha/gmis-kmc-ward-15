@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="{{ action('StreetController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
        {{-- <a href="{{ action('HumanResourceController@add') }}" class="btn btn-info">{{ __('Add new Human Resource') }}</a> --}}
    </div>
    <div class="form-horizontal">
        <div class="box-body">
            <div class="form-group col-md-6">
                {!! Form::label('id', __('ID'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::label(null, $street->id, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('strtcd', __('Code'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::label(null, $street->strtcd, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('strtnm', __('Name'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::label(null, $street->strtnm, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('vflag', __('Verification'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::label(null, $street->vflag ? __('Yes') : __('No') , ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('addrzn', __('Address Zone'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::label(null, $street->addrzn ? $street->addZone->name : '', ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
