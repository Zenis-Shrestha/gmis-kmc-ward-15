@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::model($road, ['method' => 'PATCH', 'action' => ['RoadController@update', $road->gid], 'class' => 'form-horizontal']) !!}
        @include('roads._partial-form')
    {!! Form::close() !!}
</div>
@stop
