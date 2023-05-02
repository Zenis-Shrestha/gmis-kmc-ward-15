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
            
            var selectedWard = '{{ request("ward") }}';
                if(selectedWard) {
                    $('#ward').val(selectedWard).trigger('change');
                } else {
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
                }

                var selectedBin = '{{ request("bin") }}';
                if(selectedBin) {
                    $('#bin').prepend('<option selected value="'+selectedBin+'">'+selectedBin+'</option>').select2({
                        ajax: {
                            url:"{{ route('buildings.get-bin-numbers') }}",
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
                } else {
                    $('#ward').change(function(){
                        $('#bin').prepend('<option selected=""></option>').select2({
                            ajax: {
                                url:"{{ route('buildings.get-bin-numbers') }}",
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
                }
            });
    </script>
@endpush
