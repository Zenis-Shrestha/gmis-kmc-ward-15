@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::open(['action' => 'StreetController@index', 'class' => 'form-horizontal']) !!}
        @include('streets._partial-form')
    {!! Form::close() !!}
</div>
@stop
