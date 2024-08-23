@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::open(['action' => 'POIController@index', 'class' => 'form-horizontal']) !!}
        @include('point-interest.partial-form')
    {!! Form::close() !!}
</div>
@stop
