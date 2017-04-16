<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    {!! Form::file('image') !!}
    @if(isset($category))
    {{ Html::image('recipesImages/'.$category->image, 'Recipe Image', array('height' => 150 , 'width' => 200 ,'style' => "margin-top:15px")) }}
    @endif
</div>
<div class="clearfix"></div>

<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_id', 'Parent:') !!}
    <select class="form-control" name="parent_name">
        <option value="0">Select Ctegory</option>
        @foreach($categories as $category)
        <option  value="{!! $category->id !!}" >
         {{ $category->name }}</option>
        @endforeach
    </select>
    <!-- {!! Form::number('category_id', null, ['class' => 'form-control']) !!} -->
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('categories.index') !!}" class="btn btn-default">Cancel</a>
</div>
