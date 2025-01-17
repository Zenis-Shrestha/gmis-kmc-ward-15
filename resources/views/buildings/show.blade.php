@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="{{ action('BuildingController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
        {{-- <a href="{{ action('BuildingController@add') }}" class="btn btn-info">{{ __('Add new Building') }}</a> --}}
    </div>
    <div class="form-horizontal">
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('bin', __('Building Identification Number'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->bin, ['class' => 'form-control']) !!}
                </div>
            </div>
            
            <div class="form-group">
                {!! Form::label('bldgcd', __('Building Code'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->bldgcd, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('ward', __('Ward'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->ward, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('tole', __('Place/Location'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->tole, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('oldhno', __('House Number'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->oldhno, ['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- <div class="form-group">
                {!! Form::label('haddr', __('Metric House Address'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->haddr, ['class' => 'form-control']) !!}
                </div>
            </div> -->
           
            <div class="form-group">
                {!! Form::label('strtcd', __('Road Code'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->strtcd, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('imgfl', __('Building Photo File Name'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->imgfl, ['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- <div class="form-group">
                {!! Form::label('addrzn', __('Address Zone'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->addrzn, ['class' => 'form-control']) !!}
                </div>
            </div> -->
            <!-- <div class="form-group">
                {!! Form::label('zonecode', __('Zone Code'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->zonecode, ['class' => 'form-control']) !!}
                </div>
            </div> -->
            <div class="form-group">
                {!! Form::label('bldgasc', __('Assoc. Building Number'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->bldgasc, ['class' => 'form-control']) !!}
                </div>
            </div>
            
            <div class="form-group">
                {!! Form::label('offcnm', __('Office Name'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->offcnm, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('owner_name', __('House Owner Name'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->owner_name, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('owner_contact', __('House Owner Contact Number'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->owner_contact, ['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- <div class="form-group">
                {!! Form::label('prclkey', __('Parcel Key'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->prclkey, ['class' => 'form-control']) !!}
                </div>
            </div> -->
            <div class="form-group">
                {!! Form::label('yoc', __('Year Of Construction'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->yoc, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('flrcount', __('Number Of Floors'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->flrcount, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('flrar', __('Floor Area In Sqft'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->flrar, ['class' => 'form-control']) !!}
                </div>
            </div>
            
            <div class="form-group">
                {!! Form::label('bprmtno', __('Building Permit Number'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->bprmtno, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('toilyn', __('Toilet'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->toilynYesNo ? $building->toilynYesNo->name : '', ['class' => 'form-control']) !!}
                </div>
            </div>
           
          
            <!-- <div class="form-group">
                {!! Form::label('sngwoman', __('No Of Single Woman'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->sngwoman, ['class' => 'form-control']) !!}
                </div>
            </div> -->
            <!-- <div class="form-group">
                {!! Form::label('hhcount', __('No Of Households'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->hhcount, ['class' => 'form-control']) !!}
                </div>
            </div> -->
            <!-- <div class="form-group">
                {!! Form::label('hhpop', __('Total Population'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->hhpop, ['class' => 'form-control']) !!}
                </div>
            </div> -->
            <!-- <div class="form-group">
                {!! Form::label('gt60yr', __('No Of Old Age People (>60)'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->gt60yr, ['class' => 'form-control']) !!}
                </div>
            </div> -->
            <!-- <div class="form-group">
                {!! Form::label('dsblppl', __('No Of Disabled People'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->dsblppl, ['class' => 'form-control']) !!}
                </div>
            </div> -->
            <div class="form-group">
                {!! Form::label('sbin', __('Shangrila BIN'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->sbin, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('txpyrname', __('Tax Payer\'s Name'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->txpyrname, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('txpyrid', __('Tax Payer\'s ID'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->txpyrid, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('btxyr', __('Building Tax Paid Year'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->btxyr, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('btxsts', __('Building Tax Paid Status'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null, $building->taxStsCode ? $building->taxStsCode->name : '', ['class' => 'form-control']) !!}
                </div>
            </div>
           <div class="form-group">
                {!! Form::label('btxsts', __('Building Photo'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    <img src="{{ $photo_path }}" style="height: 250px;"/>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
