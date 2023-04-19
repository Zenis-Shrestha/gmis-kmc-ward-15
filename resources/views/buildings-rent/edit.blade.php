@extends('dashboard')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
    </div>
    @include('errors.list')
    {!! Form::model($buildingRent, ['method' => 'PATCH', 'action' => ['BuildingRentController@update', $buildingRent->id], 'class' => 'form-horizontal']) !!}
        @include('buildings-rent._partial-form')
    {!! Form::close() !!}
</div>
@stop
@push('scripts')
    <script>
        $(document).ready(function() {
            
                    $('#bin').prepend('<option selected="{{$buildingRent->bin}}">{{$buildingRent->bin}}</option>').select2({
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
    </script>
@endpush
