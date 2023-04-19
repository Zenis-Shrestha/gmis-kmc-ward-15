@extends('dashboard') @section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                @ability('super-admin', 'add-user')
                <a href="{{ action('UserController@add') }}" class="btn btn-info">Add new User</a>
                @endability
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @if(!$user->hasRole('super-admin'))
                                <tr>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <?php
                                            $user_roles = array();
                                            foreach($user->roles as $role) {
                                            $user_roles[] = $role->display_name;
                                            }
                                            echo implode(', ', $user_roles);
                                        ?>
                                    </td>
                                    <td>
                                        {!! Form::open(['method' => 'DELETE','route' => ['user.destroy', $user->id]]) !!}
                                        @ability('super-admin', 'edit-user')
                                        <a href="{{ action('UserController@edit', [$user->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>@endability
                                        @ability('super-admin', 'view-user')
                                        <a href="{{ action('UserController@show', [$user->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-list"></i></a> @endability
                                        @ability('super-admin', 'delete-user')
                                        <button type="submit" class="btn btn-info btn-xs" onclick="return confirm('Are you sure?')">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button>
                                        @endability
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endif
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
