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
                        placeholder: 'WARD',
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
                    }
                    
                    
                }
            });
        })
    }
})
    </script>
@endpush
