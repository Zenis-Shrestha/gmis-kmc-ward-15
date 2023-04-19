@extends('dashboard')

@section('content')

<div class="box box-info">
	@include('errors.list')
	{!! Form::open(['url' => 'tax-payment','files'=>true, 'class' => 'form-horizontal']) !!}

        <div class="box-body">
            <div class="form-group row">
                {!! Form::label('Upload Tax Payment File',null,['class' => 'col-sm-3 control-label', 'style'=>'padding-top:3px;']) !!}
                <div class="col-sm-3">
                    {!! Form::file('excelfile') !!}
                </div>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            <a href="{{ route('tax-payment.index') }}" class="btn btn-info">Back to List</a>
            {!! Form::submit('Upload', ['class' => 'btn btn-info']) !!}
        </div><!-- /.box-footer -->
    {!! Form::close() !!}

</div><!-- /.box -->
@stop



    

