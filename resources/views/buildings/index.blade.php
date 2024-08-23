@extends('dashboard')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
               
                <a href="{{ action('BuildingController@add') }}" class="btn btn-info">Add Building</a>
              
              
                <a href="#" id="export" class="btn btn-info">Export to Excel</a>
             
              
                <a href="#" id="export-shp" class="btn btn-info">Export to Shape File</a>
              
                <a href="#" id="export-kml" class="btn btn-info">Export to KML</a>
               
                <a href="#" id="export-pdf" class="btn btn-info">Export to PDF</a>
               
            </div><!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" id="filter-form">
                    <div class="form-group">
                        <label for="bin_text"  class="control-label col-md-2">Building Identification Number (BIN)</label>
                        <div class="col-md-2"> <input type="text" class="form-control" id="bin_text" /></div>
                        
                        <label class="control-label col-md-2" for="ward_select">Ward</label>
                        <div class="col-md-2"> <select class="form-control" id="ward_select">
                            <option value="">All Wards</option>
                            @foreach($wards as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                        </div>
                        <label class="control-label col-md-2" for="hownr">House Owner</label>
                        <div class="col-md-2"> <input type="text" class="form-control" id="hownr" /></div>
                    </div>
                    
                     <div class="form-group">
                         <label class="control-label col-md-2" for="tole">Place/Location</label>
                        <div class="col-md-2"> <input type="text" class="form-control" id="tole" /></div>
                            <label class="control-label col-md-2" for="btxsts_select">Tax Paid Status</label>
                                <div class="col-md-2"> <select class="form-control" id="btxsts_select">
                                    <option value="">All</option>
                                    @foreach($dueYears as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                
                                <label class="control-label col-md-2" for="yoc_select">Year of Construction</label>
                                <div class="col-md-2"> <select class="form-control" id="yoc_select">
                                    <option value="">All</option>
                                    @foreach($yearOfConstruction as $key=>$value)
                                    <option value="{{$value}}">{{$value}}</option>
                                    @endforeach
                                    </select>
                                </div>
                               
                     </div>
                    <div class="form-group">
                         <label class="control-label col-md-2" for="strtcd">Street</label>
                                <div class="col-md-2"> 
                                    <select class="form-control" id="strtcd">
                                        <option></option>
                                    </select>
                                </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-info">Filter</button>
                        <button type="reset" class="btn btn-info reset">Reset</button>
                    </div>
                </form>
                <table id="data-table" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>{{ __('BIN') }}</th>
                            <th>{{ __('Code') }}</th>
                            <th>{{ __('Ward') }}</th>
                            <th>{{ __('Place/Location') }}</th>
                            <th>{{ __('House Owner') }}</th>
                            <th>{{ __('Tax Paid Status') }}</th>
                            <th>{{ __('Year of Contruction') }}</th>
                            <th>{{ __('Street') }}</th>
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
            url: '{!! url("buildings/data") !!}',
           
            data: function(d) {
                d.bin = $('#bin_text').val();
                d.ward = $('#ward_select').val();
                d.hownr = $('#hownr').val();
                d.due_year = $('#btxsts_select').val();
                d.yoc = $('#yoc_select').val();
                d.strtcd = $('#strtcd').val();
                d.tole = $('#tole').val();
            }
        },
        columns: [
            {data: 'bin', name: 'bin'},
            {data: 'bldgcd', name: 'bldgcd'},
            {data: 'ward', name: 'ward'},
            {data: 'tole', name: 'tole'},
            {data: 'owner_name', name: 'owner_name'},
            {data: 'taxName', name: 'taxName'},
            {data: 'yoc', name: 'yoc'},
            {data: 'strtcd', name: 'strtcd'},

            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        "order": [[ 0, 'DESC' ]]
    });

    var bin = '',  ward = '', hownr = '', due_year = '', strtcd = '', yoc ='', tole='';

    $('#filter-form').on('submit', function(e){
      e.preventDefault();
      dataTable.draw();
      bin = $('#bin_text').val();
      ward = $('#ward_select').val();
      hownr = $('#hownr').val();
      due_year = $('#btxsts_select').val();
      yoc = $('#yoc_select').val();
      strtcd = $('#strtcd').val();
      tole = $('#tole').val();
      
    });
    
    $('#data-table_filter input[type=search]').attr('readonly', 'readonly');
    $(".reset").on("click", function (e) {

                $('#bin_text').val('');
                $('#ward_select option:selected').removeAttr('selected');
                $('#hownr').val('');
                $('#btxsts_select option:selected').removeAttr('selected');
                $('#yoc_select option:selected').removeAttr('selected');
                $('#strtcd').val('');
                $('#tole').val('');
                $('#data-table').dataTable().fnDraw();
               
            })
            
    $("#export").on("click",function(e){
        e.preventDefault();
        var searchData=$('input[type=search]').val();
        var bin = $('#bin_text').val();
        var ward = $('#ward_select').val();
        var hownr = $('#hownr').val();
        var due_year = $('#btxsts_select').val();
        var yoc = $('#yoc_select').val();
        var strtcd = $('#strtcd').val();
        var tole = $('#tole').val();
        window.location.href="{!! url('buildings/export?searchData=') !!}"+searchData+"&bin="+bin+"&ward="+ward+"&hownr="+hownr+"&due_year="+due_year+"&yoc="+yoc+"&strtcd="+strtcd+"&tole="+tole;
    });


    $("#export-shp").on("click", function(e) {
        e.preventDefault();
        var cql_param = getCQLParams();
                window.location.href="<?php echo Config::get("constants.GURL_URL"); ?>/wfs?service=WFS&version=1.0.0&request=GetFeature&authkey=1f74cf78-a13c-4b0c-a5d1-dd67f7ce671a&typeName=dharan_gmis:bldg&CQL_FILTER=" + cql_param +
            "&outputFormat=SHAPE-zip";

    });

    $("#export-kml").on("click", function(e) {
        e.preventDefault();
        var cql_param = getCQLParams();
        window.location.href="<?php echo Config::get("constants.GURL_URL"); ?>/wfs?service=WFS&version=1.0.0&request=GetFeature&authkey=1f74cf78-a13c-4b0c-a5d1-dd67f7ce671a&typeName=dharan_gmis:bldg&CQL_FILTER=" + cql_param +
            "&outputFormat=KML";

    });

    $("#export-pdf").click(function(e) {
        e.preventDefault();
        const url = `report`;
        window.open(url, "Monthly Report");
    })

    function getCQLParams() {
            bin = $('#bin_text').val();
            ward = $('#ward_select').val();
            hownr = $('#hownr').val();
            due_year = $('#btxsts_select').val();
            strtcd = $('#strtcd').val();
            tole = $('#tole').val();
          

        var cql_param = "1=1";
        if (bin) {
            cql_param += " AND bin ='" + bin + "'";
        }
        
        if (ward) {
            cql_param += " AND ward = '" + ward + "'";
        }
        
        
        if (due_year == '0') {
            cql_param += " AND due_year = '" + due_year + "'";
        }
        
        if (hownr) {
            cql_param += " AND hownr = '" + hownr + "'";
        }
         if (strtcd) {
            cql_param += " AND strtcd = '" + strtcd + "'";
        }
        
        if (tole) {
            cql_param += " AND tole = '" + tole + "'";
        }
        
        return encodeURI(cql_param);
    }
         $('#strtcd').prepend('<option selected=""></option>').select2({
                    ajax: {
                        url:"{{ route('buildings.get-street-names') }}",
                        data: function (params) {
                            return {
                                search: params.term,
                                page: params.page || 1
                            };
                        },
                    },
                    placeholder: 'Street Name',
                    allowClear: true,
                    closeOnSelect: true,
                });
   
});

</script>
@endpush