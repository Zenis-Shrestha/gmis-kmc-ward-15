@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::open(['action' => 'BuildingRentController@index', 'class' => 'form-horizontal']) !!}
        @include('buildings-rent._partial-form')
    {!! Form::close() !!}
</div>
@stop
@push('scripts')
    <script>
        
         $(document).ready(function() { 
            
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
