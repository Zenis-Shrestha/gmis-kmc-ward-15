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
            if({{$buildingRent->bin}} && {{$buildingRent->ward}}){
                $('#bin').prepend('<option selected="{{$buildingRent->bin}}">{{$buildingRent->bin}}</option>').select2({
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
                    
                    var selectedWard = '{{$buildingRent->ward}}';
                    if (selectedWard) {
                        var $wards = {!! json_encode($wards) !!};
                        var $wardSelect = $('#ward');
                        
                      
                        
                        $.each($wards, function(key, value) {
                            $wardSelect.append($('<option>', {
                                value: key,
                                text: value
                            }));
                        });
                        
                        $wardSelect.val(selectedWard);
                    }


            }
                    
         });
    </script>
@endpush
