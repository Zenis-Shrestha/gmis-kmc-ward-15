@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::open(['action' => 'BuildingController@index', 'files' => true,  'class' => 'form-horizontal']) !!}
        @include('buildings._partial-form')
    {!! Form::close() !!}
</div>
@stop
