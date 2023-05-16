<div class="box-body">
    
<div class="form-group col-md-6 required">
        {!! Form::label('bin', __('Building Identification Number'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::select('bin',[],null,['class' => 'form-control', 'placeholder' => 'Building Identification Number']) !!}
            <!--{!! Form::text('bin', null, ['class' => 'form-control', 'placeholder' => __('Building Identification Number')]) !!}-->
        </div>
    </div> 
    <div class="form-group col-md-6">
        {!! Form::label('ward', __('Ward'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
        {!! Form::select('ward', [], $wards, ['class' => 'form-control', 'placeholder' => __('--- Choose ward ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('roadname', __('Road Name'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('roadname', null, ['class' => 'form-control', 'placeholder' => __('Road Name')]) !!}
        </div>
    </div>
    
    <div class="form-group col-md-6">
        {!! Form::label('houseno', __('House No.'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('houseno', null, ['class' => 'form-control', 'placeholder' => __('House No.')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('houseownername', __('House Owner Name'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('houseownername', null, ['class' => 'form-control', 'placeholder' => __('House Owner Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('ownerphone', __('House Owner Phone'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('ownerphone', null, ['class' => 'form-control', 'placeholder' => __('House Owner Phone')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('houseownermail', __('House Owner Email'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('houseownermail', null, ['class' => 'form-control', 'placeholder' => __('House Owner Email')]) !!}
        </div>
    </div>
          <div class="clearfix hidden-xs hidden-sm"> </div>

     <div class="form-group col-md-6">
        {!! Form::label('businessname', __('Business Name'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('businessname', null, ['class' => 'form-control', 'placeholder' => __('Business Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('businesowner', __('Business Owner Name'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('businesowner', null, ['class' => 'form-control', 'placeholder' => __('Business Owner Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('businessownermobile', __('Business Owner Mobile'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('businessownermobile', null, ['class' => 'form-control', 'placeholder' => __('Business Owner Mobile')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('businessmaintype', __('Business Main Type'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">

            {!! Form::select('businessmaintype', ['' => __('--- Choose Business Main Type ---')] + $businessMainTypes, null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('businesstype', __('Business Sub Type'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('businesstype', [], null, ['class' => 'form-control', 'placeholder' => __('--- Choose Business Sub Type ---')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('category', __('Category'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('category', null, ['class' => 'form-control', 'placeholder' => __('Category')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('businessoprdate', __('Business Operation Date'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('businessoprdate', null, ['class' => 'form-control', 'placeholder' => __('Business Operation Date')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('registration', __('Registration'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('registration', null, ['class' => 'form-control', 'placeholder' => __('Registration')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('oldinternalnumber', __('Old Internal Number'), ['class' => 'col-sm-4 control-label']) !!} 
        <div class="col-sm-8">
            {!! Form::text('oldinternalnumber', null, ['class' => 'form-control', 'placeholder' => __('Old Internal Number')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('taxlastdate', __('Tax Last Date(YYYY/MM/DD)'), ['class' => 'col-sm-4 control-label ']) !!}
        <div class="col-sm-8">
            {!! Form::text('taxlastdate', null, ['class' => 'form-control datepicker nepali-datepicker', 'placeholder' => __('YYYY/MM/DD')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('rent', __('Rent'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('rent', null, ['class' => 'form-control', 'placeholder' => __('Rent')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('rentresponsible', __('Rent Responsible'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('rentresponsible', null, ['class' => 'form-control', 'placeholder' => __('Rent Responsible')]) !!}
        </div>
    </div>
    
    <div class="form-group col-md-6">
        {!! Form::label('email', __('Email'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Email')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('remarks', __('Remarks'), ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('remarks', null, ['class' => 'form-control', 'placeholder' => __('Remarks')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
    {!! Form::label('registration_status', __('Registration Status'), ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
        <label>
            {!! Form::radio('registration_status', 'Yes', true) !!}
            {{ __('Yes') }}
        </label>
        <label>
            {!! Form::radio('registration_status', 'No') !!}
            {{ __('No') }}
        </label>
    </div>
</div>

    
</div>

<div class="box-footer" style="float:right;">
    <a href="{{ action('BuildingBusinessController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
    {!! Form::submit(__('Save'), ['class' => 'btn btn-info']) !!}
</div>


<div class="box-body">
<table id="data-table" class="table table-bordered table-striped" width="100%" style="display: none;" >
<thead id="table-heading" >
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Business Name') }}</th>
                            <th>{{ __('BIN') }}</th>
                            <th>{{ __('House No') }}</th>
                            <th>{{ __('Ward') }}</th>
                            <th>{{ __('Road Name') }}</th>
                            <th>{{ __('Business Owner Name') }}</th>
                            <th>{{ __('House Owner Name') }}</th>
                            <th>{{ __('Owner Phone No') }}</th>
                            <th>{{ __('Tax last Date') }}</th>
                            <th>{{ __('Registration Status') }}</th>
                        </tr>
                    </thead>
                </table>
</div>
@push('scripts')
    <script>
$(document).ready(function() {

    // Function to initialize DataTable
    function initDataTable() {
        var binValue = ($('#bin').val() !== '') ? $('#bin').val() : (new URLSearchParams(window.location.search)).get('bin') ;
    console.log("kljki",binValue); // Log the bin value
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            "bFilter" : false,
            ajax: {
                url: '{!! url("buildings-business/data") !!}',
                data: {
                    "bin": ($('#bin').val() !== '') ? $('#bin').val() : (new URLSearchParams(window.location.search)).get('bin'),
                  
                },
            },
            columns: [
                    {data: 'id', name: 'id'},
                    {data: 'businessname', name: 'businessname'},
                    {data: 'bin', name: 'bin'},
                    {data: 'houseno', name: 'houseno'},
                    {data: 'ward', name: 'ward'},
                    {data: 'roadname', name: 'roadname'},
                    {data: 'businesowner', name: 'businesowner'},
                    {data: 'houseownername', name: 'houseownername'},
                    {data: 'ownerphone', name: 'ownerphone'},
                    {data: 'taxlastdate', name: 'taxlastdate'},
                    {data : 'registration_status',
                        render : function (data, type, row) {
                                     return (data === true) ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>';}
                       },
                
                ],
                "order": [[ 0, 'DESC' ]]
        });
    }   
        // Function to prefill form fields
        function prefillForm() {
          
    $.ajax({
        url: '{{ url("building-business/business-details") }}',
        data: {
            "bin": ($('#bin').val() !== '') ? $('#bin').val() : (new URLSearchParams(window.location.search)).get('bin'),
            "ward": ($('#ward').val() !== '') ? $('#ward').val() : (new URLSearchParams(window.location.search)).get('ward'),
        },
        success: function (res) {
           
            $('#ward').val(res.ward);
            if (res.hownr) {
                $('#houseownername').val(res.hownr);
            } else {
                $('#houseownername').val(res.houseownername);
            }
            if (res.oldhno) {
                $('#houseno').val(res.oldhno);
            } else {
                $('#houseno').val(res.houseno);
            }
            $('#roadname').val(res.roadname);
            $('#ownerphone').val(res.ownerphone);
            $('#email').val(res.email);
            
        }
    });
}

        // Run the DataTable function before prefill if bin is present in the URL
   if ((new URLSearchParams(window.location.search)).get('bin')) {
    
    var bin = (new URLSearchParams(window.location.search)).get('bin');
        if (bin !== '') {     
        prefillForm();
        initDataTable();
        $('#data-table').show();
        } else {
        $('#data-table').hide();
        }
   }


   $('#bin').on('change', function(e) {
                var bin = $('#bin').val();
                var dataTable = $('#data-table').DataTable();

                if ($.fn.DataTable.isDataTable('#data-table')) {
                    dataTable.destroy();
                }

                if (bin !== '') {
                  
                    prefillForm();
                    initDataTable();
                    $('#data-table').show();
                } else {
                    $('#data-table').hide();
                }
            });


            
   var selectedBin = '{{ request("bin") }}';
                if(selectedBin) {
                    $('#bin').prepend('<option selected value="'+selectedBin+'">'+selectedBin+'</option>').select2({
                        ajax: {
                            url:"{{ route('buildings.get-bin-numbers') }}",
                            data: {
            "bin": ($('#bin').val() !== '') ? $('#bin').val() : (new URLSearchParams(window.location.search)).get('bin'),
            },
                        },
                        placeholder: 'BIN',
                        allowClear: true,
                        closeOnSelect: true,
                    });
                }  

                var selectedWard = '{{ request("ward") }}';
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



             
                

        $('#businessmaintype').change(function(){
                
                   
                var businessmaintype = $(this).val();
           
             $('#businesstype').html('<option value="">--- Choose Business Sub Type ---</option>');
             
             if(businessmaintype) {
                 loadSubTypes(businessmaintype, null);
             }
         });


        function loadSubTypes(businessmaintype, callback) {
                    
            $('#businesstype').html('<option value="">Loading...</option>');
            //$('#businesstype').attr('disabled', 'disabled');
            $.ajax({
                
                method: 'GET',
                url: '{{ url("building-business/business-sub-types") }}',
                data:{
                    businesstype : encodeURIComponent(businessmaintype),
                },
                success: function(data) {
                    data = $.parseJSON(data);
                    var html = '<option value="">--- Choose Business Sub Type ---</option>';
                    $.each(data, function(key, value){
                html += '<option value="' + value + '">' + value + '</option>';
                        });
                        $('#businesstype').html(html);
                        $('#businesstype').removeAttr('disabled');
                        @if(isset($buildingBusiness)) 
                        
                    $("#businesstype option[value='<?php echo $buildingBusiness->businesstype;?>']").attr('selected', 'selected'); 
                    @endif
                        if(callback) {
                callback(null);
                        }
                },
                error: function() {
                    $('#businesstype').html('<option value="">--- Choose Business Sub Type ---</option>');
                    $('#businesstype').removeAttr('disabled');
                    // Display error message
                    callback('error occurred');
                }
            });
        }
            
                    <?php if(isset($buildingBusiness->businessmaintype) && $buildingBusiness->businessmaintype): ?>
            
                    loadSubTypes('<?php echo $buildingBusiness->businessmaintype; ?>', function(err){
                        if(err) {
                            // do something about error
                        }
                        });
                    <?php endif; ?>
                    //               $('.datepicker').datepicker({
                    //                        dateFormat: 'mm/dd/yyyy',
                    //                        todayHighlight: true,
                    //                        defaultViewDate: {year: '2079'}
                    //                });
                    /* Select your element */
                    var currentDate = NepaliFunctions.ConvertDateFormat(NepaliFunctions.GetCurrentBsDate(), "YYYY-MM-DD");
                        $('#nepali-datepicker-1').val(currentDate);

                        $('.nepali-datepicker').nepaliDatePicker({
                            ndpYear: true,
                            ndpMonth: true,
                            dateFormat: "YYYY/MM/DD"
                        });
                    //                 $('.datepicker').focus(function(){
                    //                    $(this).blur();
                    //                });
            });

            
  

                </script>
@endpush