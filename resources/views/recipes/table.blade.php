<table class="table table-responsive" id="recipes-table">
    <thead>
        <th>Name</th>
        <th>Image</th>
        <th>Author</th>
        <th>Category Name</th>
        <th>Number Of Persons</th>
        <th>Preparation Time</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($recipes as $key => $recipe)
        <tr>
            <td><a href="{!! route('recipes.show', [$recipe->id]) !!}">{!! $recipe->name !!}<a/></td>
            <td>{{ Html::image('recipesImages/' . $recipe->image , 'alt', array( 'width' => 110, 'height' => 140 )) }}</td>
            <td>{!! $users[$key]->name !!}</td>
            <td><a href="{!! route('categories.show', [$categories[$key]->id]) !!}" >{!! $categories[$key]->name !!}</a></td>
            <td>{!! $recipe->number_of_persons !!}</td>
            <td>{!! $recipe->preparation_time !!}</td>
            <td>
                {!! Form::open(['route' => ['recipes.destroy', $recipe->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('recipes.show', [$recipe->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('recipes.edit', [$recipe->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
