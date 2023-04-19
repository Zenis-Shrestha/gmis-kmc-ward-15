@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Edit</h3>
    </div>
    @include('errors.list')
    {!! Form::model($user, ['method' => 'PATCH', 'action' => ['UserController@update', $user->id], 'class' => 'form-horizontal']) !!}
        @include('user._partial-form', ['submitButtomText' => 'Update'])
    {!! Form::close() !!}
</div>
@stop
