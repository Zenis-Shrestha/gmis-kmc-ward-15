@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::open(['action' => 'DrainageController@index', 'class' => 'form-horizontal']) !!}
        @include('drainages._partial-form')
    {!! Form::close() !!}
</div>
@stop
