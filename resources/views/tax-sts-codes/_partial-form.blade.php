<div class="box-body">
    <div class="form-group">
        {!! Form::label('name', __('Name'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Name')]) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('value', __('Value'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('value', null, ['class' => 'form-control', 'placeholder' => __('Value')]) !!}
        </div>
    </div>
</div>

<div class="box-footer">
    <a href="{{ action('TaxStsCodeController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
    {!! Form::submit(__('Save'), ['class' => 'btn btn-info']) !!}
</div>