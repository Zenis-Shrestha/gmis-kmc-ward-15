@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="{{ action('YesNoController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
        <a href="{{ action('YesNoController@add') }}" class="btn btn-info">{{ __('Add new Yes No Status') }}</a>
    </div>
    <div class="form-horizontal">
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('name', __('Name'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $yesNo->name, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('value', __('Value'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $yesNo->value, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
