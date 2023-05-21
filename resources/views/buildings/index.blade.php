@extends('dashboard')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                @ability('super-admin', 'add-building')
                <a href="{{ action('BuildingController@add') }}" class="btn btn-info">Add Building</a>
                @endability
                @ability('super-admin', 'export-buildings-excel')
                <a href="#" id="export" class="btn btn-info">Export to Excel</a>
                @endability
                @ability('super-admin', 'export-buildings-shape')
                <a href="#" id="export-shp" class="btn btn-info">Export to Shape File</a>
                @endability
                @ability('super-admin', 'export-buildings-kml')
                <a href="#" id="export-kml" class="btn btn-info">Export to KML</a>
                @endability
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
                            
                               
                                <div class="col-md-4">
                                
                                    <label class="control-label full-width">
                                        <input type="checkbox" id="sngwoman_checkbox" name="sngwoman_checkbox" value="1" />
                                        Single Women
                                    </label>
                                    <label class="control-label full-width">
                                        <input type="checkbox" id="gt60yr_checkbox" name="gt60yr_checkbox" value="1" />
                                        Old Age People
                                    </label>
                                    <label class="control-label full-width">
                                        <input type="checkbox" id="dsblppl_checkbox" name="dsblppl_checkbox" value="1" />
                                        Disabled People
                                    </label>
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
                            <th>{{ __('No. of Single Women') }}</th>
                            <th>{{ __('No. of Old Age People') }}</th>
                            <th>{{ __('No. of Disabled People') }}</th>
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
                d.sngwoman = $('#sngwoman_checkbox').is(':checked') ? '1' : '';
                d.gt60yr = $('#gt60yr_checkbox').is(':checked') ? '1' : '';
                d.dsblppl = $('#dsblppl_checkbox').is(':checked') ? '1' : '';
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
            {data: 'sngwoman', name: 'sngwoman'},
            {data: 'gt60yr', name: 'gt60yr'},
            {data: 'dsblppl', name: 'dsblppl'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        "order": [[ 0, 'DESC' ]]
    });

    var bin = '',  ward = '', hownr = '', due_year = '', sngwoman = '', dsblppl = '', gt60yr ='', yoc ='';

    $('#filter-form').on('submit', function(e){
      e.preventDefault();
      dataTable.draw();
      bin = $('#bin_text').val();
      ward = $('#ward_select').val();
      hownr = $('#hownr').val();
      due_year = $('#btxsts_select').val();
      yoc = $('#yoc_select').val();
      sngwoman = $('#sngwoman_checkbox').is(':checked') ? '1' : '';
      gt60yr = $('#gt60yr_checkbox').is(':checked') ? '1' : '';
      dsblppl = $('#dsblppl_checkbox').is(':checked') ? '1' : '';
      
    });
    
    $('#data-table_filter input[type=search]').attr('readonly', 'readonly');
    $(".reset").on("click", function (e) {

                $('#bin_text').val('');
                $('#ward_select option:selected').removeAttr('selected');
                $('#hownr').val('');
                $('#btxsts_select option:selected').removeAttr('selected');
                $('#yoc_select option:selected').removeAttr('selected');
                $('#sngwoman_checkbox').prop('checked', false); // Unchecks it
                $('#gt60yr_checkbox').prop('checked', false); // Unchecks it
                $('#dsblppl_checkbox').prop('checked', false); // Unchecks it
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
        var sngwoman = $('#sngwoman_checkbox').is(':checked') ? '1' : '';
        var gt60yr = $('#gt60yr_checkbox').is(':checked') ? '1' : '';
        var dsblppl = $('#dsblppl_checkbox').is(':checked') ? '1' : '';
        window.location.href="{!! url('buildings/export?searchData=') !!}"+searchData+"&bin="+bin+"&ward="+ward+"&hownr="+hownr+"&due_year="+due_year+"&yoc="+yoc+"&sngwoman="+sngwoman+"&gt60yr="+gt60yr+"&dsblppl="+dsblppl;
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
            var sngwoman = $('#sngwoman_checkbox').is(':checked') ? '1' : '';
            var gt60yr = $('#gt60yr_checkbox').is(':checked') ? '1' : '';
            var dsblppl = $('#dsblppl_checkbox').is(':checked') ? '1' : '';
       

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
        if (gt60yr) {
            cql_param += " AND gt60yr > 0";
        }
        if (sngwoman) {
            cql_param += " AND sngwoman > 0";
        }
        if (dsblppl) {
            cql_param += " AND dsblppl  > 0";
        }

        return encodeURI(cql_param);
    }
});
</script>
@endpush
