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
                                    page: params.page || 1,
                                  
                                };
                            },
                        },
                        placeholder: 'Bin',
                        allowClear: true,
                        closeOnSelect: true,
                    });
              

     
                    var $wards = {!! json_encode($wards) !!};
                    $('#bin').change(function(){
                        
                        $('#ward').empty();

                        // Loop through the $wards array and add an option for each ward
                        $.each($wards, function(key, value) {
                            $('#ward').append($('<option>', {
                                value: key,
                                text: value
                            }));
                        });

                       

        })
})
    </script>
@endpush
