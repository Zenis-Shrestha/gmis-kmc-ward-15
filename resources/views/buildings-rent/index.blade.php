@extends('dashboard')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
             
                <a href="{{ action('BuildingRentController@add') }}" class="btn btn-info">Add Rent</a>
          
                <a href="{{ action('BuildingRentController@export') }}" id="export" class="btn btn-info">Export to Excel</a>
              
            
                <a href="#" id="export-shp" class="btn btn-info">Export to Shape File</a>
                
                <a href="#" id="export-kml" class="btn btn-info">Export to KML</a>
              
                <a href="#" id="export-pdf" class="btn btn-info">Export to PDF</a>
              
               
            </div><!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" id="filter-form">
                    <div class="form-group">
                        <label class="control-label col-md-2" for="rentername">Renter Name</label>
                        <div class="col-md-2"> <input type="text" class="form-control" id="rentername" /></div>
                        <label class="control-label col-md-2" for="bin">Building Identification Number (BIN)</label>
                        <div class="col-md-2"> <input type="text" class="form-control" id="bin" /></div>
                        <label class="control-label col-md-2" for="roadname">Road Name</label>
                        <div class="col-md-2"> <input type="text" class="form-control" id="roadname" /></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2" for="hownername">House Owner Name</label>
                        <div class="col-md-2"> 
                            <input type="text" class="form-control" id="hownername" /></div>
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
                    <div class="text-right"><button type="submit" class="btn btn-info">Filter</button>
                    <button type="reset" class="btn btn-info reset">Reset</button></div>
                </form>
                <table id="data-table" class="table table-bordered table-striped" width="100%">
                    <thead>
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
            url: '{!! url("buildings-rent/data") !!}',
            data: function(d) {
                d.rentername = $('#rentername').val();
                d.bin = $('#bin').val();
                d.houseno = $('#houseno').val();
                d.ward = $('#ward').val();
                d.roadname = $('#roadname').val();
                d.taxpayercode = $('#taxpayercode').val();
                d.hownername = $('#hownername').val();
                d.hownernumber = $('#hownernumber').val();
            }
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
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
         "order": [[ 0, 'DESC' ]]
    });

    var rentername = '', bin = '',  ward = '', taxcode = '', houseno = '', hownername = '', roadname = '';

    $('#filter-form').on('submit', function(e){
      e.preventDefault();
      dataTable.draw();
      rentername = $('#rentername').val();
      bin = $('#bin').val();
      ward = $('#ward').val();
      houseno = $('#houseno').val();
      hownername = $('#hownername').val();
      roadname = $('#roadname').val();

    });
    $(".reset").on("click", function (e) {

        $('#bin').val('');
        $('#ward option:selected').removeAttr('selected');
        $('#houseno').val('');
        $('#hownername').val('');
        $('#roadname').val('');
        $('#rentername').val('');
        $('#data-table').dataTable().fnDraw();

    });
    $('#data-table_filter input[type=search]').attr('readonly', 'readonly');


    $("#export-pdf").click(function(e) {
        e.preventDefault();
        const url = `rent-report`;
        window.open(url, "Rent Report");
    })

    $("#export").on("click",function(e){
        e.preventDefault();
        var bin = $('#bin').val();
        var ward = $('#ward').val();
        var houseno = $('#houseno').val();
        var hownername = $('#hownername').val();
        var roadname = $('#roadname').val();
        var rentername = $('#rentername').val();
        var searchData=$('input[type=search]').val();
        window.location.href="{!! url('buildings-rent/export?searchData=') !!}"+searchData+"&bin="+bin+"&ward="+ward+"&houseno="+houseno+"&hownername="+hownername+"&roadname="+roadname+"&rentername="+rentername;
    });
    $("#export-shp").on("click", function(e) {
        e.preventDefault();
        var cql_param = getCQLParams();
                window.location.href="<?php echo Config::get("constants.GURL_URL"); ?>/wfs?service=WFS&version=1.0.0&request=GetFeature&authkey=1f74cf78-a13c-4b0c-a5d1-dd67f7ce671a&typeName=dharan_gmis:bldg_rent_tax&CQL_FILTER=" + cql_param +
            "&outputFormat=SHAPE-zip";

    });

    $("#export-kml").on("click", function(e) {
        e.preventDefault();
        var cql_param = getCQLParams();

        window.location.href="<?php echo Config::get("constants.GURL_URL"); ?>/wfs?service=WFS&version=1.0.0&request=GetFeature&authkey=1f74cf78-a13c-4b0c-a5d1-dd67f7ce671a&typeName=dharan_gmis:bldg_rent_tax&CQL_FILTER=" + cql_param +
            "&outputFormat=KML";

    });
    function getCQLParams() {
        var bin = $('#bin').val();
        var ward = $('#ward').val();
        var houseno = $('#houseno').val();
        var hownername = $('#hownername').val();
        var roadname = $('#roadname').val();
        var rentername = $('#rentername').val();
        var searchData=$('input[type=search]').val();
       

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
        
        if (hownername) {
            cql_param += " AND hownername = '" + hownername + "'";
        }
        if (roadname) {
            cql_param += " AND roadname = '" + roadname + "'";
        }
        if (rentername) {
            cql_param += " AND rentername  = '" + rentername + "'";
        }

        return encodeURI(cql_param);
    }
});
</script>
@endpush
