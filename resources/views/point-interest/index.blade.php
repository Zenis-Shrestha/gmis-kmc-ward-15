@extends('dashboard')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a href="{{ action('POIController@create') }}" class="btn btn-info">Add Point of Interest</a>
                    {{-- <a href="{{action('POIController@export') }}" id="export" class="btn btn-info">Export to Excel</a> --}}
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form class="form-inline" id="filter-form">
                        <div class="form-group">
                            <label for="name" class="control-label col-md-2">Name
                            </label>
                            <div class="col-md-2">
                                <select class="form-control" id="name">
                                    <option value="">Name</option>
                                    @foreach ($name as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="ward" class="control-label col-md-2">Ward</label>
                            <div class="col-md-2">
                                <select class="form-control" id="ward">
                                    <option value="">Ward</option>
                                    @foreach ($ward as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="type_use" class="control-label col-md-2">Type Use
                            </label>
                            <div class="col-md-2">
                                <select class="form-control" id="type_use">
                                    <option value="">Type Use</option>
                                    @foreach ($typeUse as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-info">Filter</button>
                    </form>
                    <table id="data-table" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Ward</th>
                                <th>Type</th>
                                <th>Actions</th>
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
                bFilter: true,
                processing: true,
                serverSide: true,
                scrollCollapse: true,
                stateSave: true,
                stateDuration: 1800, // In seconds; keep state for half an hour
                ajax: {
                    url: '{!! url('point-interest/data') !!}',
                    data: function(d) {
                        d.name = $('#name').val();
                        d.ward = $('#ward').val();
                        d.type_use = $('#type_use').val();
                    }
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'ward',
                        name: 'ward'
                    },
                    {
                        data: 'type_use',
                        name: 'type_use'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ]
            }).on('draw', function() {
                $('.delete').on('click', function(e) {
                    var form = $(this).closest("form");
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                'Deleted!',
                                'Point of Interest will be deleted.',
                                'success'
                            ).then((willDelete) => {
                                if (willDelete) {
                                    form.submit();
                                }
                            })
                        }
                    })
                });
            });

            $('#filter-form').on('submit', function(e) {

                e.preventDefault();
                dataTable.draw();
                name = $('#name').val();
                ward = $('#ward').val();
                type_use = $('#type_use').val();
            });

            $("#export").on("click", function(e) {
                e.preventDefault();
                var searchData = $('input[type=search]').val();
                var name = $('#name').val();
                var ward = $('#ward').val();
                var type_use = $('#type_use').val();
                window.location.href = "{!! url('point-interest/export?searchData=') !!}" + searchData + "&name=" + name + "&ward=" +
                    ward + "&type_use=" + type_use;
            });
        });
    </script>
@endpush