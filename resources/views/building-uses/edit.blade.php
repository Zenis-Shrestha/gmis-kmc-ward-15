@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::model($buildingUse, ['method' => 'PATCH', 'action' => ['BuildingUseController@update', $buildingUse->id], 'class' => 'form-horizontal']) !!}
        @include('building-uses._partial-form')
    {!! Form::close() !!}
</div>
@stop
