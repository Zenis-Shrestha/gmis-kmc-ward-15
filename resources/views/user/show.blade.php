@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="{{ action('UserController@index') }}" class="btn btn-info">Back to List</a>
        <a href="{{ action('UserController@add') }}" class="btn btn-info">Add new user</a>
    </div>
    <!-- /.box-header -->
    <div class="form-horizontal">
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('Full Name',null,['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::label($userDetail->name,null,['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('Email',null,['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::label($userDetail->email,null,['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('Role',null,['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-6">
                    <?php
                        $user_roles = array();
                        foreach($userDetail->roles as $role) {
                        $user_roles[] = $role->display_name;
                        }
                    ?>
                    {!! Form::label(implode(', ', $user_roles),null,['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('ward',null,['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::label($userDetail->ward,null,['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
