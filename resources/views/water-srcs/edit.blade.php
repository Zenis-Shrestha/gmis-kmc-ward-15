@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::model($drnkWtrSrc, ['method' => 'PATCH', 'action' => ['DrnkWtrSrcController@update', $drnkWtrSrc->id], 'class' => 'form-horizontal']) !!}
        @include('water-srcs._partial-form')
    {!! Form::close() !!}
</div>
@stop
