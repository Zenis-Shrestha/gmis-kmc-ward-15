@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::model($roadHierarchy, ['method' => 'PATCH', 'action' => ['RoadHierarchyController@update', $roadHierarchy->id], 'class' => 'form-horizontal']) !!}
        @include('road-hierarchies._partial-form')
    {!! Form::close() !!}
</div>
@stop
