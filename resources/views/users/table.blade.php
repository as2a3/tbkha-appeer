<table class="table table-responsive" id="users-table">
    <thead>
        <th>Name</th>
        <th>Email</th>
        <th>Avatar</th>
        <th>Facebook Id</th>
        <th>Facebook Token</th>
        <th>User Token</th>
        <th>Fcm Token</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{!! $user->name !!}</td>
            <td>{!! $user->email !!}</td>
            <td>{!! $user->avatar !!}</td>
            <td>{!! $user->facebook_id !!}</td>
            <td>{!! $user->facebook_token !!}</td>
            <td>{!! $user->user_token !!}</td>
            <td>{!! $user->FCM_token !!}</td>
            <td>
                {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('users.show', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>