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
            
            if({{$buildingBusiness->bin}} && {{$buildingBusiness->ward}}){
                $('#bin').prepend('<option selected="{{$buildingBusiness->bin}}">{{$buildingBusiness->bin}}</option>').select2({
                        ajax: {
                            url:"{{ route('buildings.get-bin-numbers') }}",
                            data: function (params) {
                                return {
                                    search: params.term,
                                  
                                    page: params.page || 1
                                };
                            },
                        },
                        placeholder: 'Bin',
                        allowClear: true,
                        closeOnSelect: true,
                    });
                    
                    $('#ward').prepend('<option selected="{{$buildingBusiness->ward}}">{{$buildingBusiness->ward}}</option>').select2({
                        ajax: {
                            url:"{{ route('buildings.get-wards') }}",
                            data: function (params) {
                                return {
                                    search: params.term,
                                   
                                    page: params.page || 1
                                };
                            },
                        },
                        placeholder: 'Ward',
                        allowClear: true,
                        closeOnSelect: true,
                    });
            }
                    
                
  
                 var selectedBin = '{{ request("bin") }}';
                if(selectedBin) {
                    $('#bin').val(selectedBin).trigger('change');
                } else {
                    $('#bin').select2({
                        ajax: {
                            url:"{{ route('buildings.get-bin-numbers') }}",
                            data: function (params) {
                                return {
                                    search: params.term,
                                    page: params.page || 1
                                };
                            },
                        },
                        placeholder: 'Bin',
                        allowClear: true,
                        closeOnSelect: true,
                    });
                }

                var selectedWard = '{{ request("ward") }}';
                if(selectedWard) {
                    $('#ward').prepend('<option selected value="'+selectedWard+'">'+selectedWard+'</option>').select2({
                        ajax: {
                            url:"{{ route('buildings.get-wards') }}",
                            data: function (params) {
                                return {
                                    search: params.term,
                                    bin: $('#bin').val(),
                                    page: params.page || 1
                                };
                            },
                        },
                        placeholder: 'Ward',
                        allowClear: true,
                        closeOnSelect: true,
                    });
                } else {
                    $('#bin').change(function(){
                        
                        $('#ward').prepend('<option selected=""></option>').select2({
                           
                            ajax: {
                              
                                url:"{{ route('buildings.get-wards') }}",
                                data: function (params) {
                                    return {
                                        search: params.term,
                                    bin: $('#bin').val(),
                                    page: params.page || 1
                                    }
                    },
                    
                },
                placeholder: 'Ward',
                        allowClear: true,
                        closeOnSelect: true,
            });
        })
    }
                
  
                    @if(isset($buildingBusiness)) 
                    $("#businessmaintype option[value='<?php echo $buildingBusiness->businessmaintype;?>']").attr('selected', 'selected'); // added single quotes

                    @endif
                    
                    
         });
    </script>
@endpush
