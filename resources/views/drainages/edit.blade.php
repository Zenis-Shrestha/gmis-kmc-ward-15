@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::model($drainage, ['method' => 'PATCH', 'action' => ['DrainageController@update', $drainage->id], 'class' => 'form-horizontal']) !!}
        @include('drainages._partial-form')
    {!! Form::close() !!}
</div>
@stop
