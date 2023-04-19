@extends('dashboard')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                @ability('super-admin', 'add-add-zone')
                    <a href="{{ action('AddZoneController@add') }}" class="btn btn-info">{{ __('Add new Address Zone') }}</a>
                @endability{{-- 
                @ability('super-admin', 'export-add-zones-excel')
                    <a href="{{ action('AddZoneController@export') }}" id="export" class="btn btn-info">{{ __('Export to Excel') }}</a>
                @endability --}}
            </div>
            <div class="box-body">
                <table id="data-table" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>{{ __('Short Name') }}</th>
                            <th>{{ __('Numeric Value') }}</th>
                            <th>{{ __('Full Name') }}</th>
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
            url: '{!! url("add-zones/data") !!}',
        },
        columns: [
            {data: 'addrzn', name: 'addrzn'},
            {data: 'value', name: 'value'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $("#export").on("click",function(e){
        e.preventDefault();
        var searchData=$('input[type=search]').val();
        window.location.href="{!! url('add-zones/export?searchData=') !!}"+searchData;
    });
});
</script>
@endpush
