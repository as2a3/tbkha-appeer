
<li class="{{ Request::is('categories*') ? 'active' : '' }}" id="defaultOpen">
    <a href=""><i class="fa fa-edit"></i><span>Home</span></a>
</li>

<li class="{{ Request::is('categories*') ? 'active' : '' }}">
    <a href="{!! route('categories.index') !!}"><i class="fa fa-edit"></i><span>Categories</span></a>
</li>

<li class="{{ Request::is('recipes*') ? 'active' : '' }}">
    <a href="{!! route('recipes.index') !!}"><i class="fa fa-edit"></i><span>Recipes</span></a>
</li>

<!-- <li class="{{ Request::is('ingredients*') ? 'active' : '' }}">
    <a href="{!! route('ingredients.index') !!}"><i class="fa fa-edit"></i><span>Ingredients</span></a>
</li>

<li class="{{ Request::is('steps*') ? 'active' : '' }}">
    <a href="{!! route('steps.index') !!}"><i class="fa fa-edit"></i><span>Steps</span></a>
</li> -->
<script>
document.getElementById("defaultOpen").click();

</script>
<li class="{{ Request::is('images*') ? 'active' : '' }}">
    <a href="{!! route('images.index') !!}"><i class="fa fa-edit"></i><span>images</span></a>
</li>

