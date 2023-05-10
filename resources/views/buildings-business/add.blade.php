@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::open(['action' => 'BuildingBusinessController@index', 'class' => 'form-horizontal']) !!}
 
        @include('buildings-business._partial-form')
    {!! Form::close() !!}
</div>
@stop
@push('scripts')
    <script>
        
         $(document).ready(function() { 
            $('#road_code').prepend('<option selected=""></option>').select2({
                ajax: {
                    
                    data: function (params) {
                        return {
                            search: params.term,
                            house_number: $('#house_number').val(),
                            page: params.page || 1
                        };
                    },
                },
                placeholder: 'Street Name',
                allowClear: true,
                closeOnSelect: true,
                width: '100%'
            });

           
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
        placeholder: 'BIN',
        allowClear: true,
        closeOnSelect: true,
    });
    
                
         
   
    $('#ward').select2({
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

   


         })
           
    </script>
@endpush
