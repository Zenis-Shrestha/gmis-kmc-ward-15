@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::open(['action' => 'DrnkWtrSrcController@index', 'class' => 'form-horizontal']) !!}
        @include('water-srcs._partial-form')
    {!! Form::close() !!}
</div>
@stop
