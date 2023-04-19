@extends('dashboard')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                @ability('super-admin', 'add-role')
                <a href="{{ url('roles/create') }}" class="btn btn-info">Create new Role</a> @endability
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Display Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->display_name }}</td>
                                <td>
                                    <form action="{{ url('roles/' . $role->id) }}" method="POST">
                                        {{ csrf_field() }} {{ method_field('DELETE') }}
                                        @ability('super-admin', 'edit-role')
                                        <a href="{{ url('roles/' . $role->id . '/edit') }}" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                                        @endability
                                        @ability('super-admin', 'delete-role')
                                        <button type="submit" class="btn btn-info btn-xs" onclick="return confirm('Are you sure?')">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button>
                                        @endability
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')
<script type="text/javascript">
$(function() {
    $("#table").DataTable({
        order: []
    });
});
</script>
@endpush
