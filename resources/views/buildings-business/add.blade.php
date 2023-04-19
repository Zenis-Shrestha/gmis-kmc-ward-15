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
            $('#ward').change(function(){
                        $('#bin').prepend('<option selected=""></option>').select2({
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
                    });
                    
                    
            });
    </script>
@endpush
