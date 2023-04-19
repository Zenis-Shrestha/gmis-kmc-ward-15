@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::open(['action' => 'BuildingUseController@index', 'class' => 'form-horizontal']) !!}
        @include('building-uses._partial-form')
    {!! Form::close() !!}
</div>
@stop
