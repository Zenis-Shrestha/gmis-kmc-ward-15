@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::model($yesNo, ['method' => 'PATCH', 'action' => ['YesNoController@update', $yesNo->id], 'class' => 'form-horizontal']) !!}
        @include('yes-nos._partial-form')
    {!! Form::close() !!}
</div>
@stop
