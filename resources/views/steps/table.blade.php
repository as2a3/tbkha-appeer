<table class="table table-responsive" id="steps-table">
    <thead>
        <th>Name</th>
        <th>Image</th>
        <th>Recipe Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($steps as $step)
        <tr>
            <td>{!! $step->name !!}</td>
            <td>{!! $step->image !!}</td>
            <td>{!! $step->recipe_id !!}</td>
            <td>
                {!! Form::open(['route' => ['steps.destroy', $step->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('steps.show', [$step->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('steps.edit', [$step->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>