@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::model($buildingBusiness, ['method' => 'PATCH', 'action' => ['BuildingBusinessController@update', $buildingBusiness->id], 'class' => 'form-horizontal']) !!}
        @include('buildings-business._partial-form')
    {!! Form::close() !!}
</div>
@stop
@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
                
});
</script>
    <script>
        $(document).ready(function() {
            
                    $('#bin').prepend('<option selected="{{$buildingBusiness->bin}}">{{$buildingBusiness->bin}}</option>').select2({
                        ajax: {
                            url:"{{ route('buildings-business.get-bin-numbers') }}",
                            data: function (params) {
                                return {
                                    search: params.term,
                                    ward: $('#ward').val()?$('#ward').val():'0',
                                    page: params.page || 1
                                };
                            },
                        },
                        placeholder: 'BIN',
                        allowClear: true,
                        closeOnSelect: true,
                    });
                    
                
  
                    @if(isset($buildingBusiness)) 
                    $("#businessmaintype option[value='<?php echo $buildingBusiness->businessmaintype;?>']").attr('selected', 'selected'); // added single quotes

                    @endif
                    
                    
         });
    </script>
@endpush
