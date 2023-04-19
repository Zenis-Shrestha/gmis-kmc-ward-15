@extends('dashboard')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                @ability('super-admin', 'add-street')
                <a href="{{ action('StreetController@add') }}" class="btn btn-info">Add Street</a>
                @endability
                @ability('super-admin', 'export-streets-excel')
                <a href="#{{-- action('StreetController@export') --}}" id="export" class="btn btn-info">Export to Excel</a>
                @endability
                @ability('super-admin', 'export-streets-shape')
                <a href="<?php echo Config::get("constants.GURL_URL"); ?>/wfs?service=WFS&version=1.0.0&request=GetFeature&authkey=1f74cf78-a13c-4b0c-a5d1-dd67f7ce671a&typeName=dharan_gmis:street&outputFormat=SHAPE-ZIP" class="btn btn-info">Export to Shape File</a>
                @endability
                @ability('super-admin', 'export-streets-kml')
                <a href="<?php echo Config::get("constants.GURL_URL"); ?>/wfs?service=WFS&version=1.0.0&request=GetFeature&authkey=1f74cf78-a13c-4b0c-a5d1-dd67f7ce671a&typeName=dharan_gmis:street&outputFormat=KML" class="btn btn-info">Export to KML</a>
                @endability
            </div><!-- /.box-header -->
            <div class="box-body">
                <form class="form-inline" id="filter-form">
                    <div class="form-group">                        
                        <label for="addrzn_select">Address Zone</label>
                        <select class="form-control" id="addrzn_select">
                            <option value="">All Address Zones</option>
                            @foreach($addZones as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info">Filter</button>
                </form>
                <table id="data-table" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Code') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Address Zone') }}</th>
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
            url: '{!! url("streets/data") !!}',
            data: function(d) {
                d.addrzn = $('#addrzn_select').val();
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'strtcd', name: 'strtcd'},
            {data: 'strtnm', name: 'strtnm'},
            {data: 'add_zone.name', name: 'addZone.name'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    var addrzn = '';

    $('#filter-form').on('submit', function(e){
      e.preventDefault();
      dataTable.draw();
      addrzn = $('#addrzn_select').val();
    });

    $('#data-table_filter input[type=search]').attr('readonly', 'readonly');

    $("#export").on("click",function(e){
        e.preventDefault();
        return;
        var searchData=$('input[type=search]').val();
        window.location.href="{!! url('streets/export?searchData=') !!}"+searchData;
    });
});
</script>
@endpush
