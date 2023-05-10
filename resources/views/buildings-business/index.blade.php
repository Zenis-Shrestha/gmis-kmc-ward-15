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
                            <th>{{ __('Owner Phone No') }}</th>
                            <th>{{ __('Tax last Date') }}</th>
                            <th>{{ __('Registration No.') }}</th>
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
                d.ownerphone = $('#ownerphone').val();
                d.btxsts_select = $('#btxsts_select').val();
                d.registration = $('#registration').val();
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
            {data: 'ownerphone', name: 'ownerphone'},
            {data: 'taxlastdate', name: 'taxlastdate'},
            {data: 'registration', name: 'registration'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        "order": [[ 0, 'DESC' ]]
    });

    var businessname = '', bin = '',  ward = '', road = '', taxcode = '', houseno = '', houseownername = '', businesowner = '', btxsts_select = '', registration = '';

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
        window.location.href="{!! url('buildings-business/export?searchData=') !!}"+searchData+"&bin="+bin+"&ward="+ward+"&houseno="+houseno+"&businessname="+businessname+"&businesowner="+businesowner+"&houseownername="+houseownername+"&btxsts_select="+btxsts_select+"&registration="+registration;
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
    function getCQLParams() {
            var bin = $('#bin').val();
            var ward = $('#ward').val();
            var houseno = $('#houseno').val();
            var businessname = $('#businessname').val();
            var businesowner = $('#businesowner').val();
            var houseownername = $('#houseownername').val();
            var btxsts_select = $('#btxsts_select').val();
            var registration = $('#registration').val();
       
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
        return encodeURI(cql_param);
    }
});
</script>
@endpush
