<div class="box-body">
    <div class="form-group col-md-6">
        {!! Form::label('strtcd', __('Tax Road Code'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('strtcd', null, ['class' => 'form-control', 'placeholder' => __('Tax Road Code')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('strtnm', __('Name'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('strtnm', null, ['class' => 'form-control', 'placeholder' => __('Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('vflag', __('Verification'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::checkbox('vflag') !!}
        </div>
    </div>
    <!-- <div class="form-group col-md-6">
        {!! Form::label('addrzn', __('Address Zone'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('addrzn', $addZones, null, ['class' => 'form-control', 'placeholder' => __('--- Choose address zone ---')]) !!}
        </div>
    </div> -->
</div>

<div class="box-footer">
    <a href="{{ action('StreetController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
    {!! Form::submit(__('Save'), ['class' => 'btn btn-info']) !!}
</div>
