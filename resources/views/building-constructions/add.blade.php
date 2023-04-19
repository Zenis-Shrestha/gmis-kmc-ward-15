@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::open(['action' => 'BuildingConstrController@index', 'class' => 'form-horizontal']) !!}
        @include('building-constructions._partial-form')
    {!! Form::close() !!}
</div>
@stop
