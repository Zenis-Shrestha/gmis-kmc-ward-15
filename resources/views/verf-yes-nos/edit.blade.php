@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::model($verfYesNo, ['method' => 'PATCH', 'action' => ['VerfYesNoController@update', $verfYesNo->id], 'class' => 'form-horizontal']) !!}
        @include('verf-yes-nos._partial-form')
    {!! Form::close() !!}
</div>
@stop
