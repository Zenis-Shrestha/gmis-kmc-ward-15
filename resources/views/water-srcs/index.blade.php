@extends('dashboard')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                @ability('super-admin', 'add-water-src')
                    <a href="{{ action('DrnkWtrSrcController@add') }}" class="btn btn-info">{{ __('Add new Drinking Water Source') }}</a>
                @endability
            </div>
            <div class="box-body">
                <table id="data-table" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Value') }}</th>
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
            url: '{!! url("water-srcs/data") !!}',
        },
        columns: [
            {data: 'name', name: 'name'},
            {data: 'value', name: 'value'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
    });

    $("#export").on("click",function(e){
        e.preventDefault();
        var searchData=$('input[type=search]').val();
        window.location.href="{!! url('water-srcs/export?searchData=') !!}"+searchData;
    });
});
</script>
@endpush
