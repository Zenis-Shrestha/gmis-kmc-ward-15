@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::model($addZone, ['method' => 'PATCH', 'action' => ['AddZoneController@update', $addZone->gid], 'class' => 'form-horizontal']) !!}
        @include('add-zones._partial-form')
    {!! Form::close() !!}
</div>
@stop
