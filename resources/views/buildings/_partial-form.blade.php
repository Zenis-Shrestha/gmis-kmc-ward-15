<div class="box-body">
    <div class="form-group col-md-6">
        {!! Form::label('bin', __('Building Identification Number'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('bin', null, ['class' => 'form-control', 'placeholder' => __('Building Identification Number')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('bldgcd', __('Building Code'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('bldgcd', null, ['class' => 'form-control', 'placeholder' => __('Building Code')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('ward', __('Ward'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('ward', $wards, null, ['class' => 'form-control', 'placeholder' => __('--- Choose ward ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('tole', __('Place/Location'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('tole', null, ['class' => 'form-control', 'placeholder' => __('Place/Location')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('oldhno', __('Old House Number'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('oldhno', null, ['class' => 'form-control', 'placeholder' => __('Old House Number')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('haddr', __('Metric House Address'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('haddr', null, ['class' => 'form-control', 'placeholder' => __('Metric House Address')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('haddrplt', __('Metric House Address Plate Distributed (Y/N)'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::checkbox('haddrplt') !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('strtcd', __('Street'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('strtcd', $streets, null, ['class' => 'form-control', 'placeholder' => __('--- Choose street ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('bldguse', __('Building Use'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('bldguse', $buildingUses, null, ['class' => 'form-control', 'placeholder' => __('--- Choose building use ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('hownr', __('House Owner Name'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('hownr', null, ['class' => 'form-control', 'placeholder' => __('House Owner Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('yoc', __('Year of Construction'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('yoc', null, ['class' => 'form-control', 'placeholder' => __('Year of Construction')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('flrcount', __('Number of Floors'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('flrcount', null, ['class' => 'form-control', 'placeholder' => __('Number of Floors')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
                {!! Form::label('flrar', __('Floor Area In Sqft'), ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                   {!! Form::text('flrar', null, ['class' => 'form-control', 'placeholder' => __('Floor Area In Sqft')]) !!}
                </div>
    </div>
            
    <div class="form-group col-md-6">
        {!! Form::label('bprmtno', __('Building Permit Number'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('bprmtno', null, ['class' => 'form-control', 'placeholder' => __('Building Permit Number')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('consttyp', __('Construction Type'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('consttyp', $constructionTypes, null, ['class' => 'form-control', 'placeholder' => __('--- Choose construction type ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('toilyn', __('Toilet'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('toilyn', $yesNo, null, ['class' => 'form-control', 'placeholder' => __('--- Choose option ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('hhcount', __('Number of households'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('hhcount', null, ['class' => 'form-control', 'placeholder' => __('Number of households')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('hhpop', __('Household populations'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('hhpop', null, ['class' => 'form-control', 'placeholder' => __('Household populations')]) !!}
        </div>
    </div>
    {{-- <div class="form-group col-md-6">
        {!! Form::label('txpyrid', __('Tax Payer\'s ID'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('txpyrid', null, ['class' => 'form-control', 'placeholder' => __('Tax Payer\'s ID')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('txpyrname', __('Tax Payer\'s Name'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('txpyrname', null, ['class' => 'form-control', 'placeholder' => __('Tax Payer\'s Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('btxsts', __('Building Tax Paid Status'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('btxsts', $taxStatuses, null, ['class' => 'form-control', 'placeholder' => __('--- Choose tax paid status ---')]) !!}
        </div>
    </div> --}}

    <div class="form-group col-md-6">
        {!! Form::label('sngwoman', __('Single Woman'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('sngwoman', null, ['class' => 'form-control', 'placeholder' => __('Single Woman')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('gt60yr', __('Greater than 60 year'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('gt60yr', null, ['class' => 'form-control', 'placeholder' => __('Greater than 60 year')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('dsblppl', __('Number of disabled people'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('dsblppl', null, ['class' => 'form-control', 'placeholder' => __('Number of disabled people')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('offcnm', __('Office Name'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('offcnm', null, ['class' => 'form-control', 'placeholder' => __('Office Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
                {!! Form::label('house_new_photo','House Photo',['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::file('house_new_photo', ['class' => 'form-control']) !!}
                </div>
    </div>
    <div class="form-group col-md-6">
                {!! Form::label('kml_file','KML File',['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::file('kml_file', ['class' => 'form-control']) !!}
                </div>
    </div>
</div>

<div class="box-footer">
    <a href="{{ action('BuildingController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
    {!! Form::submit(__('Save'), ['class' => 'btn btn-info']) !!}
</div>

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('.chosen-select').chosen();
    $('.nepali-datepicker').nepaliDatePicker({
        npdMonth: true,
        npdYear: true
    });
});
</script>
@endpush