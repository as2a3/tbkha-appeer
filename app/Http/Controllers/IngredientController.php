<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Repositories\IngredientRepository;
use App\Repositories\RecipeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Redirect;

class IngredientController extends AppBaseController
{
    /** @var  IngredientRepository */
    private $ingredientRepository;
    private $recipeRepository;

    public function __construct(IngredientRepository $ingredientRepo ,RecipeRepository $recipeRepo)
    {
        $this->ingredientRepository = $ingredientRepo;
        $this->recipeRepository = $recipeRepo;
    }

    /**
     * Display a listing of the Ingredient.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->ingredientRepository->pushCriteria(new RequestCriteria($request));
        $ingredients = $this->ingredientRepository->all();
        $recipes=[];
        foreach ($ingredients as $key => $value) {
          array_push($recipes , ($this->recipeRepository->findWhere(['id' => $value['recipe_id']])->first())['name']);
        }
        return view('ingredients.index')
            ->with('ingredients', $ingredients)->with('recipes', $recipes);
    }

    /**
     * Show the form for creating a new Ingredient.
     *
     * @return Response
     */
    public function create()
    {
        $recipes    = $this->recipeRepository->all();
        return view('ingredients.create')->with('recipes', $recipes);
    }

    /**
     * Store a newly created Ingredient in storage.
     *
     * @param CreateIngredientRequest $request
     *
     * @return Response
     */
    public function store(CreateIngredientRequest $request)
    {
        $input = $request->all();
        $input['recipe_id'] = $input['recipe_name'];
        $ingredient = $this->ingredientRepository->create($input);

        Flash::success('Ingredient saved successfully.');

        return redirect(route('ingredients.index'));
    }

    /**
     * Display the specified Ingredient.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ingredient = $this->ingredientRepository->findWithoutFail($id);

        if (empty($ingredient)) {
            Flash::error('Ingredient not found');

            return redirect(route('ingredients.index'));
        }
        $recipe = ($this->recipeRepository->findWhere(['id' => $ingredient['recipe_id']])->first())['name'];

        return view('ingredients.show')->with('ingredient', $ingredient)->with('recipe', $recipe);
    }

    /**
     * Show the form for editing the specified Ingredient.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ingredient = $this->ingredientRepository->findWithoutFail($id);

        if (empty($ingredient)) {
            Flash::error('Ingredient not found');

            return redirect(route('ingredients.index'));
        }
        $recipes    = $this->recipeRepository->all();
        return view('ingredients.edit')->with('ingredient', $ingredient)->with('recipes', $recipes);
    }

    /**
     * Update the specified Ingredient in storage.
     *
     * @param  int              $id
     * @param UpdateIngredientRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateIngredientRequest $request)
    {
        $ingredient = $this->ingredientRepository->findWithoutFail($id);

        if (empty($ingredient)) {
            Flash::error('Ingredient not found');

            return redirect(route('ingredients.index'));
        }

        $ingredient = $this->ingredientRepository->update($request->all(), $id);

        Flash::success('Ingredient updated successfully.');

        return redirect(route('ingredients.index'));
    }

    /**
     * Remove the specified Ingredient from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $ingredient = $this->ingredientRepository->findWithoutFail($id);

        if (empty($ingredient)) {
            Flash::error('Ingredient not found');

            return redirect(route('ingredients.index'));
        }

        $this->ingredientRepository->delete($id);

        return "true";
    }
}
