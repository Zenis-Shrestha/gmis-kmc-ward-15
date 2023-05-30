@extends('dashboard')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                @ability('super-admin', 'add-building-business')
                <a href="{{ action('BuildingBusinessController@add') }}" class="btn btn-info">Add Business</a>
                @endability
                @ability('super-admin', 'export-buildings-business-excel')
                <a href="#" id="export" class="btn btn-info">Export to Excel</a>
                @endability
                @ability('super-admin', 'export-buildings-business-shape')
                <a href="#" id="export-shp" class="btn btn-info">Export to Shape File</a>
                @endability
                @ability('super-admin', 'export-buildings-business-kml')
                <a href="#" id="export-kml" class="btn btn-info">Export to KML</a>
                @endability
                @ability('super-admin', 'export-buildings-business-pdf')
                <a href="#" id="export-pdf" class="btn btn-info">Export to PDF</a>
                @endability
              
               
            </div><!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" id="filter-form">
                    <div class="form-group">
                        <label class="control-label col-md-2" for="bin">Business Name</label>
                        <div class="col-md-2"> <input type="text" class="form-control" id="businessname" /></div>
                        <label class="control-label col-md-2" for="bin">Building Identification Number (BIN)</label>
                        <div class="col-md-2"> <input type="text" class="form-control" id="bin" /></div>
                        <label class="control-label col-md-2" for="roadname">Road Name</label>
                        <div class="col-md-2"> <input type="text" class="form-control" id="roadname" /></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2" for="houseownername">House Owner Name</label>
                        <div class="col-md-2"> 
                            <input type="text" class="form-control" id="houseownername" /></div>
                        <label class="control-label col-md-2" for="houseno">House No</label>
                        <div class="col-md-2"> <input type="text" class="form-control" id="houseno" /></div>
                        <label class="control-label col-md-2" for="ward">Ward</label>
                        <div class="col-md-2"> <select class="form-control" id="ward">
                            <option value="">All Wards</option>
                            @foreach($wards as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                        </div>
                       
                        
                    </div>
                    <div class="form-group">
                            <label for="btxsts_select" class="control-label col-md-2">Tax Paid Status</label>
                                <div class="col-md-2"> <select class="form-control" id="btxsts_select">
                                    <option value="">All</option>
                                    @foreach($taxStatuses as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                    </select></div>
                            <label class="control-label col-md-2" for="registration">Registration No.</label>
                                <div class="col-md-2"> 
                                    <input type="text" class="form-control" id="registration" /></div>
                                     <label for="registration_status" class="col-md-2 col-form-label text-right">Registration Status</label>
                            <div class="col-md-2">
                            <select class="form-control chosen-select" id="registration_status" name="registration_status">
                                <option value="">--- Choose Registration Status ---</option>
                                
                                <option value="true">Yes</option>
                                <option value="false">No</option>
                               
                            </select>
                            </div>
                    </div>

                 
                    <div class="form-group">
                                    <label class="control-label col-md-2" for="businesowner">Business Owner Name</label>
                                                <div class="col-md-2"> 
                                                    <input type="text" class="form-control" id="businesowner" /></div>
                                    <label for="businessmaintype" class="control-label col-md-2">Business Main Type</label>
                                                <div class="col-md-2">
                                                    <select class="form-control" id="businessmaintype">
                                                        <option value=""> Choose Business Main Type </option>
                                                        @foreach($businessMainTypes as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label for="businesstype" class="control-label col-md-2">Business Sub Type</label>
                                                <div class="col-md-2">
                                                    <select class="form-control" id="businesstype" placeholder="--- Choose Business Sub Type ---">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                    </div>
                    <div class="form-group">
                                <label class="control-label col-md-2" for="oldinternalnumber">Old Internal Number</label>
                                 <div class="col-md-2"> 
                                    <select class="form-control" id="oldinternalnumber">
                                        <option value=""> Choose old internal number </option>
                                        @foreach($oldinternalnumber as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select></div>
                            </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-info">Filter</button>
                        <button type="reset" class="btn btn-info reset">Reset</button>
                    </div>
                </form>
                <table id="data-table" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Business Name') }}</th>
                            <th>{{ __('BIN') }}</th>
                            <th>{{ __('House No') }}</th>
                            <th>{{ __('Ward') }}</th>
                            <th>{{ __('Road Name') }}</th>
                            <th>{{ __('Business Owner Name') }}</th>
                            <th>{{ __('House Owner Name') }}</th>
                            <th>{{ __('Old Internal No.') }}</th>
                            <th>{{ __('Tax Last Date') }}</th>
                            <th>{{ __('Registration No.') }}</th>
                            <th>{{ __('Registration Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')
<script>
$(function() {
    $('#oldinternalnumber').select2();
    var dataTable = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        
        ajax: {
            url: '{!! url("buildings-business/data") !!}',
            data: function(d) {
                d.businessname = $('#businessname').val();
                d.bin = $('#bin').val();
                d.houseno = $('#houseno').val();
                d.ward = $('#ward').val();
                d.roadname = $('#roadname').val();
                d.businesowner = $('#businesowner').val();
                d.houseownername = $('#houseownername').val();
                
                d.btxsts_select = $('#btxsts_select').val();
                d.registration = $('#registration').val();
                d.oldinternalnumber = $('#oldinternalnumber').val();
                d.registration_status = $('#registration_status').val();
              
                d.businessmaintype = $('#businessmaintype').val();
                d.businesstype = $('#businesstype').val();
                
              
            }
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
            {data: 'oldinternalnumber', name: 'oldinternalnumber'},
            {data: 'taxlastdate', name: 'taxlastdate'},
            {data: 'registration', name: 'registration'},
            {data : 'registration_status',
             render : function (data, type, row) {
                          return (data == true) ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>';}
            },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        "order": [[ 0, 'DESC' ]]
    });

    var businessname = '', bin = '',  ward = '', road = '', taxcode = '', houseno = '', houseownername = '', businesowner = '', btxsts_select = '', registration = '', registration_status ='', businessmaintype='', businesstype='';

    $('#filter-form').on('submit', function(e){
      e.preventDefault();
      dataTable.draw();
      businessname = $('#businessname').val();
      road = $('#roadname').val();
      bin = $('#bin').val();
      ward = $('#ward').val();
      houseno = $('#houseno').val();
      businesowner = $('#businesowner').val();
      houseownername = $('#houseownername');
      btxsts_select = $('#btxsts_select');
      registration = $('#registration');
      registration_status = $('#registration_status');
      businessmaintype = $('#businessmaintype');
      businesstype = $('#businesstype');
      oldinternalnumber = $('#oldinternalnumber');
    });
    $(".reset").on("click", function (e) {

        $('#bin').val('');
        $('#ward option:selected').removeAttr('selected');
        $('#houseno').val('');
        $('#businessname').val('');
        $('#businesowner').val('');
        $('#houseownername').val('');
        $('#btxsts_select').val('');
        $('#registration').val('');
        $('#registration_status').val('');
        $('#businessmaintype').val('');
        $('#businesstype').val('');
        $('#oldinternalnumber').val('');
        $('#data-table').dataTable().fnDraw();

    })
    $('#data-table_filter input[type=search]').attr('readonly', 'readonly');

    $("#export").on("click",function(e){
        e.preventDefault();
        var searchData=$('input[type=search]').val();
        var bin = $('#bin').val();
        var ward = $('#ward').val();
        var houseno = $('#houseno').val();
        var businessname = $('#businessname').val();
        var businesowner = $('#businesowner').val();
        var houseownername = $('#houseownername').val();
        var btxsts_select = $('#btxsts_select').val();
        var registration = $('#registration').val();
        var registration_status = $('#registration_status').val();
        var businessmaintype = $('#businessmaintype').val();
        var businesstype = $('#businesstype').val();
        var oldinternalnumber = $('#oldinternalnumber').val();
        window.location.href="{!! url('buildings-business/export?searchData=') !!}"+searchData+"&bin="+bin+"&ward="+ward+"&houseno="+houseno+"&businessname="+businessname+"&businesowner="+businesowner+"&houseownername="+houseownername+"&btxsts_select="+btxsts_select+"&registration="+registration+"&businessmaintype="+businessmaintype+"&businesstype="+businesstype+"&oldinternalnumber="+oldinternalnumber+"&registration_status="+registration_status;
    });
    $("#export-shp").on("click", function(e) {
        e.preventDefault();
        var cql_param = getCQLParams();
                window.location.href="<?php echo Config::get("constants.GURL_URL"); ?>/wfs?service=WFS&version=1.0.0&request=GetFeature&authkey=1f74cf78-a13c-4b0c-a5d1-dd67f7ce671a&typeName=dharan_gmis:bldg_business_tax_btxsts&CQL_FILTER=" + cql_param +
            "&outputFormat=SHAPE-zip";

    });

    $("#export-kml").on("click", function(e) {
        e.preventDefault();
        var cql_param = getCQLParams();

        window.location.href="<?php echo Config::get("constants.GURL_URL"); ?>/wfs?service=WFS&version=1.0.0&request=GetFeature&authkey=1f74cf78-a13c-4b0c-a5d1-dd67f7ce671a&typeName=dharan_gmis:bldg_business_tax_btxsts&CQL_FILTER=" + cql_param +
            "&outputFormat=KML";

    });

    $("#export-pdf").click(function(e) {
        e.preventDefault();
        const url = `business-report`;
        window.open(url, "Monthly Report");
    })

    function getCQLParams() {
            var bin = $('#bin').val();
            var ward = $('#ward').val();
            var houseno = $('#houseno').val();
            var businessname = $('#businessname').val();
            var businesowner = $('#businesowner').val();
            var houseownername = $('#houseownername').val();
            var btxsts_select = $('#btxsts_select').val();
            var registration = $('#registration').val();
            var registration_status = $('#registration_status').val();
            var businessmaintype = $('#businessmaintype').val();
            var businesstype = $('#businesstype').val();
            var oldinternalnumber = $('#oldinternalnumber').val();
       
        var cql_param = "1=1";
        if (bin) {
            cql_param += " AND bin ='" + bin + "'";
        }
        
        if (ward) {
            cql_param += " AND ward = '" + ward + "'";
        }
        
        
        if (houseno == '0') {
            cql_param += " AND houseno = '" + houseno + "'";
        }
        
        if (businessname) {
            cql_param += " AND businessname = '" + businessname + "'";
        }
        if (businesowner) {
            cql_param += " AND businesowner = '" + businesowner + "'";
        }
        if (houseownername) {
            cql_param += " AND houseownername  = '" + houseownername + "'";
        }
        if (btxsts_select) {
            cql_param += " AND btxsts  = '" + btxsts_select + "'";
        }
        if (registration) {
            cql_param += " AND registration  = '" + registration + "'";
        }
        if (registration_status) {
            cql_param += " AND registration_status  = '" + registration_status + "'";
        }
        if (businessmaintype) {
            cql_param += " AND businessmaintype  = '" + businessmaintype + "'";
        }
        if (businesstype) {
            cql_param += " AND businesstype  = '" + businesstype + "'";
        }

        if (oldinternalnumber) {
            cql_param += " AND oldinternalnumber  = '" + oldinternalnumber + "'";
        }
        return encodeURI(cql_param);
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
            


});
</script>
@endpush
