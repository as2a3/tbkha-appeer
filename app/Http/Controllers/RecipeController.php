<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Repositories\RecipeRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use App\Repositories\IngredientRepository;
use App\Repositories\StepRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Input;

class RecipeController extends AppBaseController
{
    /** @var  RecipeRepository */
    private $recipeRepository;
    private $categoryRepository;
    private $userRepository;
    private $ingredientRepository;
    private $stepRepository;


    public function __construct(RecipeRepository $recipeRepo ,IngredientRepository $ingredientRepo ,StepRepository $stepRepo ,CategoryRepository $categoryRepo ,UserRepository $userRepo)
    {
        $this->recipeRepository     = $recipeRepo;
        $this->ingredientRepository = $ingredientRepo;
        $this->stepRepository       = $stepRepo;
        $this->categoryRepository   = $categoryRepo;
        $this->userRepository       = $userRepo;
    }

    /**
     * Display a listing of the Recipe.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->recipeRepository->pushCriteria(new RequestCriteria($request));
        $recipes    = $this->recipeRepository->all();
        $categories = [];
        $users = [];
        foreach ($recipes as $key => $value) {
          array_push($categories , ($this->categoryRepository->findWhere(['id' => $value['category_id']])->first()));
          array_push($users , ($this->userRepository->findWhere(['id' => $value['user_id']])->first()));
        }
        return view('recipes.index')
            ->with('recipes', $recipes)->with('categories', $categories)->with('users', $users);
    }

    /**
     * Show the form for creating a new Recipe.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->all();
        return view('recipes.create')->with('categories',$categories);
    }

    /**
     * Store a newly created Recipe in storage.
     *
     * @param CreateRecipeRequest $request
     *
     * @return Response
     */
    public function store(CreateRecipeRequest $request)
    {
        $input = $request->all();
        if ($request->input('category_name')!=0) {
          $input['category_id'] = $request->input('category_name');
        }
        if (Input::file('image')) {
          $input['image'] = Input::file('image')->getClientOriginalName();
          $request->file('image')->move(public_path().'/recipesImages/', $input['image']);
        }
        $input['user_id'] = Auth::id();
        $recipe = $this->recipeRepository->create($input);
        foreach ($input['ingredients'] as $key => $value) {
          $data       = [ 'name' =>  $value ,'recipe_id' => $recipe['id']];
          $ingredient = $this->ingredientRepository->create($data);
        }
        foreach ($input['steps_names'] as $key => $value) {
          $step_data       = [ 'name' =>  $value ,'recipe_id' => $recipe['id']];
          if (!empty($input['images'][$key])) {
            $step_data['image'] = $input['images'][$key]->getClientOriginalName();
            $input['images'][$key]->move(public_path().'/stepsImages/', $step_data['image']);
          }
          $step = $this->stepRepository ->create($step_data);
        }
        Flash::success('Recipe saved successfully.');

        return redirect(route('recipes.index'));
    }

    /**
     * Display the specified Recipe.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $recipe = $this->recipeRepository->findWithoutFail($id);
        $category = $this->categoryRepository->findWhere(['id' => $recipe['category_id']])->first();
        $ingredients = $this->ingredientRepository->findWhere(['recipe_id' => $recipe['id']]);
        $steps       = $this->stepRepository->findWhere(['recipe_id' => $recipe['id']]);
        $user = $this->userRepository->findWhere(['id' => $recipe['user_id']])->first();
        if (empty($recipe)) {
            Flash::error('Recipe not found');

            return redirect(route('recipes.index'));
        }

        return view('recipes.show')->with('recipe', $recipe)->with('category', $category)
        ->with('user', $user)->with('ingredients', $ingredients)->with('steps',$steps);
    }

    /**
     * Show the form for editing the specified Recipe.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $recipe = $this->recipeRepository->findWithoutFail($id);

        if (empty($recipe)) {
            Flash::error('Recipe not found');

            return redirect(route('recipes.index'));
        }
        $categories         = $this->categoryRepository->all();
        $ingredients = $this->ingredientRepository->findWhere(['recipe_id' => $recipe['id']]);
        $steps       = $this->stepRepository->findWhere(['recipe_id' => $recipe['id']]);
        return view('recipes.edit')->with('recipe', $recipe)->with('categories',$categories)
                                  ->with('ingredients', $ingredients)->with('steps',$steps);
    }

    /**
     * Update the specified Recipe in storage.
     *
     * @param  int              $id
     * @param UpdateRecipeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRecipeRequest $request)
    {
        $recipe = $this->recipeRepository->findWithoutFail($id);
        $input  = $request->all();
        if (empty($recipe)) {
            Flash::error('Recipe not found');
            return redirect(route('recipes.index'));
        }
        $input['category_id'] = $request->input('category_name');
        if (Input::file('image')) {
          $input['image']=$input['image']->getClientOriginalName();
          $request->file('image')->move(public_path().'/recipesImages/', $input['image']);
        }
        $input['image'] = $recipe['image'];
        $recipe = $this->recipeRepository->update($input, $id);
        $ingredients = $this->ingredientRepository->findWhere(['recipe_id' => $recipe['id']]);
        $steps       = $this->stepRepository->findWhere(['recipe_id' => $recipe['id']]);
        foreach ($input['ingredients'] as $key => $value) {
          $data       = [ 'name' =>  $value ,'recipe_id' => $recipe['id']];
          if (!empty($ingredients[$key])) {
            $ingredient = $this->ingredientRepository->update($data,$ingredients[$key]['id']);
          }else {
            $ingredient = $this->ingredientRepository->create($data);
          }
        }
        foreach ($input['steps_names'] as $key => $value) {
          $step_data       = [ 'name' =>  $value ,'recipe_id' => $recipe['id']];
          if (!empty($input['images'][$key])) {
            $step_data['image'] = $input['images'][$key]->getClientOriginalName();
            $input['images'][$key]->move(public_path().'/stepsImages/', $step_data['image']);
          }
          if (!empty($steps[$key])) {
            $ingredient = $this->stepRepository->update($step_data,$steps[$key]['id']);
          }else {
            $ingredient = $this->stepRepository->create($step_data);
          }
        }

        Flash::success('Recipe updated successfully.');

        return redirect(route('recipes.index'));
    }

    /**
     * Remove the specified Recipe from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $recipe = $this->recipeRepository->findWithoutFail($id);

        if (empty($recipe)) {
            Flash::error('Recipe not found');

            return redirect(route('recipes.index'));
        }

        $this->recipeRepository->delete($id);

        Flash::success('Recipe deleted successfully.');

        return redirect(route('recipes.index'));
    }

    public function upload_image(Request $request){
    // $myFile=$_FILES['file']['image'];
      // $input = Input::all();
  //     $file = Input::file('file');
  //     $file->getClientOriginalName();
  //     $file->getClientOriginalExtension();
  //     $file->getSize();
  // $input = Input::all();
  // return response()->json($input);
      print_r(Input::all());
      if (Input::file())
       {
          return "file present";
       }
       else{
           return "file not present";
       }
      // $sourcePath = $_FILES['image']['tmp_name'];
      // $targetPath = public_path().'/recipesImages/'.$_FILES['image']['name'];
      // $img_path   = move_uploaded_file($sourcePath,$targetPath);
      // return json_encode($img_path);
      // var_dump($_FILES);
      // $name = $_FILES["image"]["name"];
      // $name = explode("_", $name);
      // $imagename='';
      // foreach($name as $letter){
      //    $imagename .= $letter;
      // }
      // move_uploaded_file( $_FILES["image"]["tmp_name"], "images/uploads/" .  $name);
      // var_dump($request->all()); die;
      // if($model_name == 'step'){
      //   // $step_data['image'] = $input['images'][$key]->getClientOriginalName();
      //   $image_src->move(public_path().'/stepsImages/',$image_src);
      // }else {
        // $image = ($request->all())['file']->getClientOriginalName();
        // $name->move(public_path().'/recipesImages/',$name);
      // }
    }

}
