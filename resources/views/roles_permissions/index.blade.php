@extends('dashboard')

@section('content')
    {!! Form::open(['url' => '/role_permission']) !!}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Permission</th>
                @foreach($roles as $role)
                    <th class="text-center">{{ $role->display_name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>

        @foreach($permissions as $permission)
            <tr>
                <td width="150">{{ $permission->display_name }}</td>
                @foreach ($roles as $role)
                    <td width="150" class="text-center">
                    @if(array_key_exists($role->id, $role_perm) && in_array($permission->id, $role_perm[$role->id]))
                        <input type="checkbox" checked="checked" name="roles[{{ $role->id}}][permissions][]" value="{{ $permission->id }}">
                    @else
                        <input type="checkbox" name="roles[{{ $role->id }}][permissions][]" value="{{ $permission->id }}">
                    @endif
                    </td>
                @endforeach
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-info']) !!}
    </div>
    {!! Form::close() !!}

@stop