@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::model($building, ['method' => 'PATCH','files' => true,  'action' => ['BuildingController@update', $building->bin], 'class' => 'form-horizontal']) !!}
        @include('buildings._partial-form')
    {!! Form::close() !!}
</div>
@stop
