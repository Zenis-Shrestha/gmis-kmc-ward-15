@extends('dashboard')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                
                <a href="{{ action('RoadController@add') }}" class="btn btn-info">Add Road</a>
              
                <a href="#{{-- action('RoadController@export') --}}" id="export" class="btn btn-info">Export to Excel</a>
               
                <a href="<?php echo Config::get("constants.GURL_URL"); ?>/wfs?service=WFS&version=1.0.0&authkey=1f74cf78-a13c-4b0c-a5d1-dd67f7ce671a&request=GetFeature&typeName=dharan_gmis:road&outputFormat=SHAPE-ZIP" class="btn btn-info">Export to Shape File</a>
              
                <a href="<?php echo Config::get("constants.GURL_URL"); ?>/wfs?service=WFS&version=1.0.0&request=GetFeature&authkey=1f74cf78-a13c-4b0c-a5d1-dd67f7ce671a&typeName=dharan_gmis:road&outputFormat=KML" class="btn btn-info">Export to KML</a>
                
            </div><!-- /.box-header -->
            <div class="box-body">
                <form class="form-inline" id="filter-form">
                    <div class="form-group">
                        <label for="strtnm_text">Road Name</label>
                        <input type="text" class="form-control" id="strtnm_text" />
                        
                        <label for="strtcd_select">Road Code</label>
                        <select class="form-control" id="strtcd_select">
                            <option value="">All Roads</option>
                            @foreach($streets as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>

                        <label for="rdwidth_text">Road Width</label>
                        <input type="text" class="form-control" id="rdwidth_text" />
                        
                        <label for="rdsurf_select">Road Surface</label>
                        <select class="form-control" id="rdsurf_select">
                            <option value="">All Road Surfaces</option>
                            @foreach($roadSurfaces as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info">Filter</button>
                </form>
                <table id="data-table" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Code') }}</th>
                            <th>{{ __('Length') }}</th>
                            <th>{{ __('Width') }}</th>
                            <th>{{ __('Hierarchy') }}</th>
                            <th>{{ __('Surface') }}</th>
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
            url: '{!! url("roads/data") !!}',
            data: function(d) {
                d.strtnm = $('#strtnm_text').val();
                d.strtcd = $('#strtcd_select').val();
                d.rdwidth = $('#rdwidth_text').val();
                d.rdsurf = $('#rdsurf_select').val();
            }
        },
        columns: [
            {data: 'strtnm', name: 'strtnm'},
            {data: 'street.strtcd', name: 'street.strtcd'},
            {data: 'rdlen', name: 'rdlen'},
            {data: 'rdwidth', name: 'rdwidth'},
            {data: 'road_hierarchy.name', name: 'roadHierarchy.name'},
            {data: 'road_surface.name', name: 'roadSurface.name'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    var strtnm = '', strtcd = '', rdwidth = '',  rdsurf = '';

    $('#filter-form').on('submit', function(e){
      e.preventDefault();
      dataTable.draw();
      strtnm = $('#strtnm_text').val();
      strtcd = $('#strtcd_select').val();
      rdwidth = $('#rdwidth_text').val();
      rdsurf = $('#rdsurf_select').val();
    });

    $('#data-table_filter input[type=search]').attr('readonly', 'readonly');

    $("#export").on("click",function(e){
        e.preventDefault();
        return;
        var searchData=$('input[type=search]').val();
        window.location.href="{!! url('roads/export?searchData=') !!}"+searchData;
    });
});
</script>
@endpush
