<div class="box-body">
    <div class="form-group col-md-6">
        {!! Form::label('rdsgcd', __('Road Segment Code'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('rdsgcd', null, ['class' => 'form-control', 'placeholder' => __('Road Segment Code')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('strtcd', __('Street'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('strtcd', $streets, null, ['class' => 'form-control', 'placeholder' => __('--- Choose street ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('strtnm', __('Street Name'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('strtnm', null, ['class' => 'form-control', 'placeholder' => __('Street Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('rdlen', __('Road Length'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('rdlen', null, ['class' => 'form-control', 'placeholder' => __('Road Length')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('rdwidth', __('Road Width'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('rdwidth', null, ['class' => 'form-control', 'placeholder' => __('Road Width')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('row', __('Right Of Way'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('row', null, ['class' => 'form-control', 'placeholder' => __('Right Of Way')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('vflag', __('Verification'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('vflag', $verfYesNo, null, ['class' => 'form-control', 'placeholder' => __('--- Choose verification status ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('addrzn', __('Address Zone'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('addrzn', $addZones, null, ['class' => 'form-control', 'placeholder' => __('--- Choose address zone ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('rdhier', __('Road Hierarchy'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('rdhier', $roadHierarchies, null, ['class' => 'form-control', 'placeholder' => __('--- Choose hierarchy ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('rdsurf', __('Road Surface'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('rdsurf', $roadSurfaces, null, ['class' => 'form-control', 'placeholder' => __('--- Choose surface ---')]) !!}
        </div>
    </div>
</div>

<div class="box-footer">
    <a href="{{ action('RoadController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
    {!! Form::submit(__('Save'), ['class' => 'btn btn-info']) !!}
</div>

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('.chosen-select').chosen();
});
</script>
@endpush