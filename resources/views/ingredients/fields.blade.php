<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Recipe Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recipe_id', 'Recipe Id:') !!}
    <select class="form-control" name="recipe_name">
        <option value="0">Select Category</option>
        @foreach($recipes as $recipe)
        <option  value="{!! $recipe->id !!}" @if(isset($ingredient->recipe_id)) @if ($recipe->id ==$ingredient->recipe_id ) {{ 'selected' }} @endif @endif>
         {{ $recipe->name }}</option>
        @endforeach
    </select>
    <!-- {!! Form::number('category_id', null, ['class' => 'form-control']) !!} -->
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('ingredients.index') !!}" class="btn btn-default">Cancel</a>
</div>
