@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::open(['action' => 'YesNoController@index', 'class' => 'form-horizontal']) !!}
        @include('yes-nos._partial-form')
    {!! Form::close() !!}
</div>
@stop
