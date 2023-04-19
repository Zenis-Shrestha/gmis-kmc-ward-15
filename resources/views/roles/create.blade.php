@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        
    </div>
    @include('errors.list')
    <form class="form-horizontal form-label-left" method="post" action="{{ url($url) }}">
        @if(isset($method) && $method)
            <input type="hidden" name="_method" value="{{ $method }}">
        @endif
        {!! csrf_field() !!}
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="name">Name</label>
                <div class="col-sm-3">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" value="{{ $role ? $role->name : '' }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="name">Display Name</label>
                <div class="col-sm-3">
                    <input type="text" id="display_name" name="display_name" class="form-control" placeholder="Display Name" value="{{ $role ? $role->display_name : '' }}">
                </div>
            </div>
        </div>
        <div class="box-footer">
            <a href="{{ url('roles') }}" class="btn btn-info">Back to List</a>
            <input type="submit" class="btn btn-info" value="Save" />
        </div>
    </form>
</div>
@stop