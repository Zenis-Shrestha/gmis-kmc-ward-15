@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::model($roadSurface, ['method' => 'PATCH', 'action' => ['RoadSurfaceController@update', $roadSurface->id], 'class' => 'form-horizontal']) !!}
        @include('road-surfaces._partial-form')
    {!! Form::close() !!}
</div>
@stop
