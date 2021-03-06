<table class="table table-responsive" id="ingredients-table">
    <thead>
        <th>Name</th>
        <th>Recipe Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($ingredients as $key => $ingredient)
        <tr>
            <td>{!! $ingredient->name !!}</td>
            <td>{!! $recipes[$key] !!}</td>
            <td>
                {!! Form::open(['route' => ['ingredients.destroy', $ingredient->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('ingredients.show', [$ingredient->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('ingredients.edit', [$ingredient->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
