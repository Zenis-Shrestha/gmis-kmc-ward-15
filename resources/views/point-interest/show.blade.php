{{-- <!-- Last Modified Date: 18-04-2024
Developed By: Innovative Solution Pvt. Ltd. (ISPL)  (© ISPL, 2022) -->
@extends('layouts.dashboard')
@section('title', $page_title)
@section('content')
<div class="card card-info">
    <div class="card-header bg-transparent">
        <a href="{{ action('POIController@index') }}" class="btn btn-info">Back to List</a>

    </div><!-- /.card-header -->
    
</div><!-- /.box -->
@stop --}}





@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="{{ action('POIController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
        {{-- <a href="{{ action('BuildingRentController@add') }}" class="btn btn-info">{{ __('Add new Building') }}</a> --}}
    </div>
    <div class="form-horizontal">
        <div class="card-body">
            <div class="form-group row">
                {!! Form::label(null,'ID',['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null,$pointInterest->id,['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('name',null,['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null,$pointInterest->name,['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('ward',null,['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null,$pointInterest->ward,['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('type',null,['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::label(null,$typeuse,['class' => 'form-control']) !!}
                </div>
            </div>
        </div><!-- /.box-body -->
    </div>
</div>
@stop
