<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control' , 'accept' => "image/*"]) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6" id="img_div">
    {!! Form::label('image', 'Image:') !!}
    {!! Form::file('image',['id' => "upload"]) !!}
    @if(isset($recipe))
    {{ Html::image('recipesImages/'.$recipe->image, 'Recipe Image', array('height' => 150 , 'width' => 200 ,'style' => "margin-top:15px")) }}
    @endif
</div>
<div class="clearfix"></div>

<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category Id:') !!}
    <select class="form-control" name="category_name">
        <option value="0">Select Category</option>
        @foreach($categories as $category)
        <option  value="{!! $category->id !!}" @if(isset($recipe->category_id)) @if ($category->id ==$recipe->category_id ) {{ 'selected' }} @endif @endif>
         {{ $category->name }}</option>
        @endforeach
    </select>
    <!-- {!! Form::number('category_id', null, ['class' => 'form-control']) !!} -->
</div>

<!-- Number Of Persons Field -->
<div class="form-group col-sm-6">
    {!! Form::label('number_of_persons', 'Number Of Persons:') !!}
    {!! Form::number('number_of_persons', null, ['class' => 'form-control']) !!}
</div>

<!-- Preparation Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('preparation_time', 'Preparation Time:') !!}
    {!! Form::text('preparation_time', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>


<!-- ingredient Name Field -->
@if (isset($ingredients))
  @foreach($ingredients as $ingredient)
    <div class="form-group col-sm-12" id="ingredients{!! $ingredient->id !!}">
        {!! Form::label('ingredient_name', 'Ingredient Name:') !!}
        {!! Form::text('name',  $ingredient->name , [ 'placeholder' => 'ingredient name','class' => 'form-control' , 'name' => 'ingredients[]' ]) !!}
        {!! Form::button('<i class="glyphicon glyphicon-remove"></i>', ['type' => 'button', 'class' => 'btn  btn-xs delete_ingredient' ,'id' => $ingredient->id]) !!}
    </div>
  @endforeach
@else
  <div class="form-group col-sm-12">
      {!! Form::label('ingredient_name', 'Ingredient Name:') !!}
      {!! Form::text('name', null , [ 'placeholder' => 'ingredient name','class' => 'form-control' , 'name' => 'ingredients[]' ]) !!}
  </div>
@endif
<!-- New Ingredients  -->
<div class="form-group col-sm-12" id="add_ingred"></div>
<!-- add another ingredient Field -->
<div class="form-group col-sm-12" >
  {{ Form::button('Add another ingredient', array('class' => 'btn btn-default  new_ingredient')) }}
    <!-- <button class="btn btn-primary submit new_ingredient" type="button">Add another ingredient </button> -->
</div>


<!-- Step Name Field -->
@if (isset($steps))
  @foreach($steps as $step)
    <div class="form-group col-sm-12" id="steps{!! $step->id !!}">
        {!! Form::label('step_name', 'Step Name:') !!}
        {!! Form::text('name', $step->name, ['placeholder' => 'Step Description' ,'class' => 'form-control' , 'name' => 'steps_names[]' ,'style' => 'margin-bottom:5px']) !!}
    <!-- Image Field -->
        {!! Form::file('images[]',['class' => "form-control col-sm-6"]) !!}
        {!! Form::button('<i class="glyphicon glyphicon-remove"></i>', ['type' => 'button', 'class' => 'btn  btn-xs delete_step' ,'id' => $step->id]) !!}

    </div>
    <div class="clearfix"></div>
  @endforeach
@else
  <div class="form-group col-sm-12">
      {!! Form::label('step_name', 'Step Name:') !!}
      {!! Form::text('name', null, ['placeholder' => 'Step Description' ,'class' => 'form-control' , 'name' => 'steps_names[]' ,'style' => 'margin-bottom:5px']) !!}
  <!-- Image Field -->
      {!! Form::file('images[]',['class' => "form-control col-sm-6"]) !!}
  </div>
@endif
<!-- New Steps  -->
<div class="form-group col-sm-12" id="add_step"></div>
<!-- add another Step Field -->
<div class="form-group col-sm-12" >
  {{ Form::button('Add another step', array('class' => 'btn btn-default  new_step')) }}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('recipes.index') !!}" class="btn btn-default">Cancel</a>
</div>
