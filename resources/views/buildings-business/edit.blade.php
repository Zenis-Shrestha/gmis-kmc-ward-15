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
                    

                    var selectedWard = '{{$buildingBusiness->ward}}';
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
                    

           
                   
                    @if(isset($buildingBusiness)) 
                    $("#businessmaintype option[value='<?php echo $buildingBusiness->businessmaintype;?>']").attr('selected', 'selected'); // added single quotes

                    @endif
                    
                    
         });
    </script>
@endpush
