<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRecipeAPIRequest;
use App\Http\Requests\API\UpdateRecipeAPIRequest;
use App\Models\Recipe;
use App\Repositories\RecipeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Request as auth_request;
use Response;

/**
 * Class RecipeController
 * @package App\Http\Controllers\API
 */

class RecipeAPIController extends AppBaseController
{
    /** @var  RecipeRepository */
    private $recipeRepository;
    private $userRepository;

    public function __construct(RecipeRepository $recipeRepo, UserRepository $userRepo)
    {
        $this->recipeRepository = $recipeRepo;
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the Recipe.
     * GET|HEAD /recipes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->recipeRepository->pushCriteria(new RequestCriteria($request));
        $this->recipeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $recipes = $this->recipeRepository->all();

        return $this->sendResponse($recipes->toArray(), 'Recipes retrieved successfully');
    }

    /**
     * Store a newly created Recipe in storage.
     * POST /recipes
     *
     * @param CreateRecipeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRecipeAPIRequest $request)
    {
        $input                     = $request->all();
        // save recipe
        $recipe                    = [];
        $recipe->name              = $input['name'];
        $recipe->image_id          = $input['cover'];
        $recipe->user_id           = $input['name'];
        $recipe->category_id       = $input['category'];
        $recipe->number_of_persons = $input['serving'];
        $recipe->preparation_time  = $input['preparing'];
        // $recipe->description       = $input['name'];
        $recipe->enabled           = 0;
        $recipe->featured          = 0;
        $recipe = $this->recipeRepository->create($recipe);
        // save ingredients
        foreach ($input['ingredients'] as $key => $value) {
          $data       = [ 'name' =>  $value ,'recipe_id' => $recipe['id']];
          $ingredient = $this->ingredientRepository->create($data);
        }
        // save steps
        foreach ($input['steps'] as $key => $value) {
          $step_data = [ 'name' =>  $value['step'], 'image_id' => $value['image'],'recipe_id' => $recipe['id']];
          $step      = $this->stepRepository ->create($step_data);
        }
        return $this->sendResponse($this->recipeRepository->recipe_object($recipe), 'Recipes retrieved successfully');
        // return $this->sendResponse($recipe->toArray(), 'Recipe saved successfully');
    }

    /**
     * Display the specified Recipe.
     * GET|HEAD /recipes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Recipe $recipe */
        $recipes = [];
        $recipe = $this->recipeRepository->findWithoutFail($id);
        // check if user logged
        $user_id = 0;
        if (auth_request::header('Authorization')) {
          $user_id = $this->userRepository->findWhere(['user_token' => auth_request::header('Authorization')])->first()['id'];
        }
        if (empty($recipe)) {
            return $this->sendError('Recipe not found');
        }
        array_push($recipes, $recipe);
        return $this->sendResponse($this->recipeRepository->recipe_object($recipes,$user_id), 'Recipe retrieved successfully');
    }

    /**
     * Update the specified Recipe in storage.
     * PUT/PATCH /recipes/{id}
     *
     * @param  int $id
     * @param UpdateRecipeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRecipeAPIRequest $request)
    {
        $input = $request->all();

        /** @var Recipe $recipe */
        $recipe = $this->recipeRepository->findWithoutFail($id);

        if (empty($recipe)) {
            return $this->sendError('Recipe not found');
        }

        $recipe = $this->recipeRepository->update($input, $id);

        return $this->sendResponse($recipe->toArray(), 'Recipe updated successfully');
    }

    /**
     * Remove the specified Recipe from storage.
     * DELETE /recipes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Recipe $recipe */
        $recipe = $this->recipeRepository->findWithoutFail($id);

        if (empty($recipe)) {
            return $this->sendError('Recipe not found');
        }

        $recipe->delete();

        return $this->sendResponse($id, 'Recipe deleted successfully');
    }

    /*
    *  list all recipes with pagination
    *  search specific recipes with pagination
    */
    public function list_all($page ,$token=null){
      // check if user logged
      $user_id = 0;
      if (auth_request::header('Authorization')) {
        $user_id = $this->userRepository->findWhere(['user_token' => auth_request::header('Authorization')])->first()['id'];
      }
      if (isset($page)) {
        if ($token != null) {
            $available_recipes = $this->recipeRepository->scopeQuery(function($query) use ($token,$page) {
              return $query->where('name', 'LIKE', '%'.$token.'%')->paginate(10, ['*'], 'page' ,$page);
            })->all();
            return $this->sendResponse($this->recipeRepository->recipe_object($available_recipes,$user_id), 'Recipes retrieved successfully');
        }
        $recipes = $this->recipeRepository->scopeQuery(function($query) use ($page) {
             return $query->paginate(10, ['*'], 'page' ,$page);
         })->all();
         return $this->sendResponse($this->recipeRepository->recipe_object($recipes,$user_id), 'Recipes retrieved successfully');
      }

    }

    /*
    * list recipes of specific category
    */
    public function category_recipes($category_id,$page){
      // check if user logged
      $user_id = 0;
      if (auth_request::header('Authorization')) {
        $user_id = $this->userRepository->findWhere(['user_token' => auth_request::header('Authorization')])->first()['id'];
      }
      $recipes = $this->recipeRepository->scopeQuery(function($query) use ($category_id,$page) {
           return $query->where('category_id' , '=' ,$category_id)->paginate(10, ['*'], 'page' ,$page);
       })->all();
       return $this->sendResponse($this->recipeRepository->recipe_object($recipes,$user_id), 'Recipes retrieved successfully');
    }

    /*
    * user published recipes
    */
    public function user_recipes($user_id ,$page ,$state){
      // check if user logged
      $user_id = 0;
      if (auth_request::header('Authorization')) {
        $user_id = $this->userRepository->findWhere(['user_token' => auth_request::header('Authorization')])->first()['id'];
      }
      $recipes = $this->recipeRepository->scopeQuery(function($query) use ($user_id,$page,$state) {
           return $query->where('user_id' , '=' ,$user_id)
                        ->where('enabled' , '=' ,$state)
                        ->paginate(10, ['*'], 'page' ,$page);
       })->all();
       return $this->sendResponse($this->recipeRepository->recipe_object($recipes,$user_id), 'Recipes retrieved successfully');
    }

    /*
    * featured published recipes
    */
    public function featured_recipes(){
        // check if user logged
        $user_id = 0;
        if (auth_request::header('Authorization')) {
          $user_id = $this->userRepository->findWhere(['user_token' => auth_request::header('Authorization')])->first()['id'];
        }
       $recipes = $this->recipeRepository->findWhere(['featured' => 1]);
       return $this->sendResponse($this->recipeRepository->recipe_object($recipes,$user_id), 'Recipes retrieved successfully');
    }



}
