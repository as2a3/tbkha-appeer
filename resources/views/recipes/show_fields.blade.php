<!-- Image Field -->
<div class="form-group">
    {{ Html::image('recipesImages/' . $recipe->image , 'alt', array( 'width' => 1000, 'height' => 300 ,'position' => 'relative' )) }}
    <span style="position: absolute;
    color: white; top: 150px;right: 0;padding: 15px;font: bold 50px/70px Helvetica, Sans-Serif;
    ">{!! $recipe->name !!}</span>
    <span style="position: absolute;
    color: white; top: 200px;right: 0;padding: 15px;font: bold 50px/70px Helvetica, Sans-Serif;
    ">{!! $user->name !!}</span>
</div>

<!-- Name Field -->
<div class="form-group">
  <table class="table table-responsive" id="recipes-table">
      <thead>
          <th>ingredients</th>
          <th>preparation time</th>
          <th>number of persons</th>
      </thead>
      <tbody>
          <tr>
              <td>{!! count($ingredients) !!}</td>
              <td>{!! $recipe->preparation_time !!}</td>
              <td>{!! $recipe->number_of_persons !!}</td>
          </tr>
      </tbody>
  </table>
</div>

<div class="form-group">
  <table class="table table-responsive" id="recipes-table">
      <thead>
          <th><h1>ingredients</h1></th>
      </thead>
      <tbody>
        @foreach($ingredients as $ingredient)
          <tr>
              <td>{!! $ingredient->name !!}</td>
          </tr>
        @endforeach
      </tbody>
  </table>
</div>


<div class="form-group">
  <table class="table table-responsive" id="recipes-table">
      <thead>
          <th><h1>Steps</h1></th>
      </thead>
      <tbody>
        @foreach($steps as $step)
          <tr>
              <td>{!! $step->name !!}</td>
              @if($step->image)
              <td>
                {{ Html::image('stepsImages/' . $step->image , 'alt',  array('width' => 110, 'height' => 140 )) }}
              </td>
              @endif
          </tr>
        @endforeach
      </tbody>
  </table>
</div>
