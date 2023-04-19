@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::model($taxStsCode, ['method' => 'PATCH', 'action' => ['TaxStsCodeController@update', $taxStsCode->id], 'class' => 'form-horizontal']) !!}
        @include('tax-sts-codes._partial-form')
    {!! Form::close() !!}
</div>
@stop
