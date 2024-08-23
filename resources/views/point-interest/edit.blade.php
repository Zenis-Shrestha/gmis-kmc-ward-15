<!-- Last Modified Date: 18-04-2024
Developed By: Innovative Solution Pvt. Ltd. (ISPL)  (© ISPL, 2022) -->
@extends('layouts.layers')
@section('title', $page_title)
@section('content')
@include('layouts.components.error-list')
@include('layouts.components.success-alert')
@include('layouts.components.error-alert')
<div class="card card-info">
	{!! Form::model($pointInterest, ['method' => 'PATCH', 'action' => ['UtilityInfo\PointInterestController@update', $pointInterest->id], 'class' => 'form-horizontal']) !!}
		@include('utility-info/point-interest.partial-form', ['submitButtomText' => 'Update'])
	{!! Form::close() !!}
</div><!-- /.card -->
@stop
