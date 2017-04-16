<table class="table table-responsive" id="categories-table">
    <thead>
        <th>Name</th>
        <th>Image</th>
        <th>Parent</th>
    </thead>
    <tbody>
        <tr>
            <td>{!! $category->name !!}</td>
            <td><img src="{{url('/')}}/CategoriesImages/{!! $category->image !!}" alt="" height="70" width="100"/></td>
            @if($parent_category)
            <td>{!! $parent_category->name !!}</td>
            @endif
        </tr>

    </tbody>
</table>
