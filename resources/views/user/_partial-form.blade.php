<div class="box-body">
    <div class="form-group">
        {!! Form::label('name','Full Name',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('name',null,['class' => 'form-control', 'placeholder' => 'Full Name']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('email',null,['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('email',null,['class' => 'form-control', 'placeholder' => 'Email']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('password',null,['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-3">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('password_confirmation','Confirm Password',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-3">
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('Role',null,['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::select('role[]', $roles, null, ['class' => 'form-control chosen-select', 'id' => 'role', 'multiple' => true]) !!}
        </div>
    </div>
</div>
<div class="box-footer">
    <a href="{{ action('UserController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
    {!! Form::submit(__('Save'), ['class' => 'btn btn-info']) !!}
</div>

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('.chosen-select').chosen();
});
</script>
@endpush
