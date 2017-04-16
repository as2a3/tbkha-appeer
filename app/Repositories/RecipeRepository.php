<?php

namespace App\Repositories;

use App\Models\Recipe;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Http\Request;

class RecipeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'user_id',
        'category_id',
        'number_of_persons',
        'preparation_time',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Recipe::class;
    }

    /*
    * prepare recipe object for return
    */
    public function recipe_object($recipes,$authenticate){
      $user_recipes = [];
      $category     = [];
      foreach ($recipes as $key => $recipe) {
        $recipe_ingredients           = $recipe->ingredients;
        $recipe_steps                 = $recipe->recipeSteps;
        $recipe_user                  = $recipe->user;
        $recipe->number_of_likes      = count($recipe->likes);
        $recipe_category              = $recipe->recipeCategory;
        if ($recipe_steps) {
          $recipe_step = [];
          foreach ($recipe_steps as $key => $step) {
            if ($step->image) {
              $step->image['image'] = 'stepsImages/'.$step->image['image'];
              $step = ((collect($step))->only('id','name','image'))->all();
              array_push($recipe_step,$step);
            }else {
              $step = ((collect($step))->only('id','name'))->all();
              array_push($recipe_step,$step);
            }
          }
        }
        if ($recipe_category) {
            $children       = [];
            $category_image = $recipe_category->image;
            if ($recipe_category->parent_category == null) {
              $subcategories = $recipe_category->subcategories;
              if (!($subcategories->isEmpty())) {
                foreach ($subcategories as $key => $child) {
                  $child->image['image'] = 'CategoriesImages/'.$child->image['image'];
                  $child->recipe_count   = count($child->recipes);
                  $child                 = ((collect($child))->only('id', 'name', 'image', 'recipe_count'))->all();
                  array_push($children,$child);
                }
                $recipe_category['children'] = $children;
              }
                $recipe_category = ((collect($recipe_category))->except('parent_category','recipes','subcategories','image_id','created_at','updated_at','deleted_at'))->all();
            }else {
              $parent                 = $recipe_category->parentCategory;
              $parent->image['image'] = 'CategoriesImages/'.$parent->image['image'];
              $parent->recipe_count   = count($parent->recipes);
              $parent                 = ((collect($parent))->only('id', 'name', 'image', 'recipe_count'))->all();
              $recipe_category['parent']     = $parent;
              $recipe_category               = ((collect($recipe_category))->except('parent_category','recipes','subcategories','image_id','created_at','updated_at','deleted_at'))->all();
            }
            $category       = $recipe_category;
        }
        if ($authenticate != 0) {
          $plucked = ($recipe->likes)->pluck('user_id');
            if(in_array($authenticate, $plucked->toArray())){
              $recipe->liked = 'true';
            }else {
              $recipe->liked = 'false';
            }
        }else {
          $recipe->liked = 'false';
        }
        if ($recipe->featured == 1) {
          $recipe->featured='true';
        }else {
          $recipe->featured='false';
        }
        $recipe->image['image'] = 'recipesImages/'.$recipe->image['image'];
        $recipe->steps = $recipe_step;
        $recipe->category = $category;
        $recipe = ((collect($recipe))->except('user_id','recipe_category','likes','recipe_steps','category_id','updated_at','deleted_at'))->all();
        $recipe['created_at'] = strtotime($recipe['created_at']);
        array_push($user_recipes,$recipe);
      }
      // dd($user_recipes);
      return $user_recipes;
    }


}
