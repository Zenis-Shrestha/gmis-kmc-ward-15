<div class="box-body">
    <div class="form-group">
        {!! Form::label('addrzn', __('Short Name'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('addrzn', null, ['class' => 'form-control', 'placeholder' => __('Short Name')]) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('value', __('Numeric Value'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('value', null, ['class' => 'form-control', 'placeholder' => __('Numeric Value')]) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('name', __('Full Name'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Full Name')]) !!}
        </div>
    </div>
</div>

<div class="box-footer">
    <a href="{{ action('AddZoneController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
    {!! Form::submit(__('Save'), ['class' => 'btn btn-info']) !!}
</div>