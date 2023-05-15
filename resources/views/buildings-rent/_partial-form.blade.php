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
            {!! Form::select('ward', [], null, ['class' => 'form-control', 'placeholder' => __('--- Choose ward ---')]) !!}
        </div>
    </div>
   
    <div class="form-group col-md-6">
        {!! Form::label('roadname', __('Road Name'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('roadname', null, ['class' => 'form-control', 'placeholder' => __('Road Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('houseno', __('House Number'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('houseno', null, ['class' => 'form-control', 'placeholder' => __('House Number')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('taxpayercode', __('Tax Payer Code'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('oldhno', null, ['class' => 'form-control', 'placeholder' => __('Old House Number')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('hownername', __('House Owner Name'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('hownername', null, ['class' => 'form-control', 'placeholder' => __('House Owner Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('hownernumber', __('House Owner Contact Number'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('hownernumber', null, ['class' => 'form-control', 'placeholder' => __('House Owner Contact Number')]) !!}       
         </div>
        </div>
    
    <div class="form-group col-md-6">
        {!! Form::label('howneremail', __('House Owner Email'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('howneremail', null, ['class' => 'form-control', 'placeholder' => __('House Owner Email')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('housetype', __('House Type'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('housetype', null, ['class' => 'form-control', 'placeholder' => __('House Type')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('locatedat', __('Locate Date'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('locatedat', null, ['class' => 'form-control', 'placeholder' => __('Locate Date')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('length', __('Length'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('length', null, ['class' => 'form-control', 'placeholder' => __('Length')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('width', __('Width'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('width', null, ['class' => 'form-control', 'placeholder' => __('Width')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('area', __('Area'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('area', null, ['class' => 'form-control', 'placeholder' => __('Area')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('rentername', __('Renter Name'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('rentername', null, ['class' => 'form-control', 'placeholder' => __('Renter Name')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('rentpurpose', __('Rent Purpose'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('rentpurpose', null, ['class' => 'form-control', 'placeholder' => __('Rent Purpose')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('rentstart', __('Rent Start'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('rentstart', null, ['class' => 'form-control', 'placeholder' => __('Rent Start')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('rentend', __('Rent End'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('rentend', null, ['class' => 'form-control', 'placeholder' => __('Rent End')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('monthlyrent', __('Monthly Rent'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('monthlyrent', null, ['class' => 'form-control', 'placeholder' => __('Monthly Rent')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('rentaxresponsible', __('Rent Tax Responsible'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('rentaxresponsible', null, ['class' => 'form-control', 'placeholder' => __('Rent Tax Responsible')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('rentincreseperyear', __('Rent Increase Per Year'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('rentincreseperyear', null, ['class' => 'form-control', 'placeholder' => __('Rent Increase Per Year')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('rentmobilenumber', __('Rent Mobile Number'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('rentmobilenumber', null, ['class' => 'form-control', 'placeholder' => __('Rent Mobile Number')]) !!}
        </div>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('remarks', __('Remarks'), ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('remarks', null, ['class' => 'form-control', 'placeholder' => __('Remarks')]) !!}
        </div>
    </div>
</div>

<div class="box-footer " style="float:right;">
    <a href="{{ action('BuildingRentController@index') }}" class="btn btn-info">{{ __('Back to List') }}</a>
    {!! Form::submit(__('Save'), ['class' => 'btn btn-info']) !!}
</div>

<div class="box-body">
<table id="data-table" class="table table-bordered table-striped" width="100%" style="display: none;" >
<thead id="table-heading" >
                        <tr>
                        <th>{{ __('ID') }}</th>
                            <th>{{ __('Renter Name') }}</th>
                            <th>{{ __('BIN') }}</th>
                            <th>{{ __('House No') }}</th>
                            <th>{{ __('Ward') }}</th>
                            <th>{{ __('Road Name') }}</th>
                            <th>{{ __('Tax Payer Code') }}</th>
                            <th>{{ __('House Owner Name') }}</th>
                            <th>{{ __('Owner Phone No') }}</th>
                        </tr>
                    </thead>
                </table>
</div>
@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
   // Function to initialize DataTable
   function initDataTable() {

        $('#data-table').DataTable({
            
            processing: true,
            serverSide: true,
            "bFilter" : false,
            ajax: {
                url: '{!! url("buildings-rent/data") !!}',
                data: {
                    "bin": ($('#bin').val() !== '') ? $('#bin').val() : (new URLSearchParams(window.location.search)).get('bin'),
                },
            },
            columns: [
                    {data: 'id', name: 'id'},
                    {data: 'rentername', name: 'rentername'},
                    {data: 'bin', name: 'bin'},
                    {data: 'houseno', name: 'houseno'},
                    {data: 'ward', name: 'ward'},
                    {data: 'roadname', name: 'roadname'},
                    {data: 'taxpayercode', name: 'taxpayercode'},
                    {data: 'hownername', name: 'hownername'},
                    {data: 'hownernumber', name: 'hownernumber'},
                ],
                "order": [[ 0, 'DESC' ]]
        });
    }   
        // Function to prefill form fields
     function prefillForm() {
        $.ajax({
            url: '{{ url("building-rent/rent-details") }}',
            data: {
            "bin": ($('#bin').val() !== '') ? $('#bin').val() : (new URLSearchParams(window.location.search)).get('bin'),
            },
            success: function (res) {
            
           if(res.oldhno){
            $('#houseno').val(res.oldhno);
           }else {
            $('#houseno').val(res.houseno);
           }
           
           if( res.hownr){
            $('#hownername').val(res.hownr);
           }else{
            $('#hownername').val(res.hownername);
           }
            
            $('#roadname').val(res.roadname);
            $('#hownernumber').val(res.hownernumber);
            $('#howneremail').val(res.howneremail);
            $('#housetype').val(res.housetype);
            $('#length').val(res.length);
            $('#area').val(res.area);
            $('#width').val(res.width);
           
            }
        });
    
    }
        // Run the DataTable function before prefill if bin is present in the URL
   if ((new URLSearchParams(window.location.search)).get('bin')) {
        if (bin !== '') {
        prefillForm();
        initDataTable();
        $('#data-table').show();
        } else {
        $('#data-table').hide();
        }
   }

   
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
                if(selectedWard) {
                    $('#ward').prepend('<option selected value="'+selectedWard+'">'+selectedWard+'</option>').select2({
                        ajax: {
                            url:"{{ route('buildings.get-wards') }}",
                            data: {
            "ward": ($('#ward').val() !== '') ? $('#ward').val() : (new URLSearchParams(window.location.search)).get('ward'),
            },
                        },
                        placeholder: 'BIN',
                        allowClear: true,
                        closeOnSelect: true,
                    });
                }  


   $('#bin').on('change', function(e){
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

   
   
});
</script>
@endpush