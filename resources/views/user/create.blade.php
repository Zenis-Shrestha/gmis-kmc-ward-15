@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::open(['url' => 'user', 'class' => 'form-horizontal']) !!}
        @include('user._partial-form', ['submitButtomText' => 'Save'])
    {!! Form::close() !!}
</div>
@stop

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('.chosen-select').chosen();
});
</script>
@endpush
