<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateIngredientAPIRequest;
use App\Http\Requests\API\UpdateIngredientAPIRequest;
use App\Models\Ingredient;
use App\Repositories\IngredientRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class IngredientController
 * @package App\Http\Controllers\API
 */

class IngredientAPIController extends AppBaseController
{
    /** @var  IngredientRepository */
    private $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepo)
    {
        $this->ingredientRepository = $ingredientRepo;
    }

    /**
     * Display a listing of the Ingredient.
     * GET|HEAD /ingredients
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->ingredientRepository->pushCriteria(new RequestCriteria($request));
        $this->ingredientRepository->pushCriteria(new LimitOffsetCriteria($request));
        $ingredients = $this->ingredientRepository->all();

        return $this->sendResponse($ingredients->toArray(), 'Ingredients retrieved successfully');
    }

    /**
     * Store a newly created Ingredient in storage.
     * POST /ingredients
     *
     * @param CreateIngredientAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateIngredientAPIRequest $request)
    {
        $input = $request->all();

        $ingredients = $this->ingredientRepository->create($input);

        return $this->sendResponse($ingredients->toArray(), 'Ingredient saved successfully');
    }

    /**
     * Display the specified Ingredient.
     * GET|HEAD /ingredients/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Ingredient $ingredient */
        $ingredient = $this->ingredientRepository->findWithoutFail($id);

        if (empty($ingredient)) {
            return $this->sendError('Ingredient not found');
        }

        return $this->sendResponse($ingredient->toArray(), 'Ingredient retrieved successfully');
    }

    /**
     * Update the specified Ingredient in storage.
     * PUT/PATCH /ingredients/{id}
     *
     * @param  int $id
     * @param UpdateIngredientAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateIngredientAPIRequest $request)
    {
        $input = $request->all();

        /** @var Ingredient $ingredient */
        $ingredient = $this->ingredientRepository->findWithoutFail($id);

        if (empty($ingredient)) {
            return $this->sendError('Ingredient not found');
        }

        $ingredient = $this->ingredientRepository->update($input, $id);

        return $this->sendResponse($ingredient->toArray(), 'Ingredient updated successfully');
    }

    /**
     * Remove the specified Ingredient from storage.
     * DELETE /ingredients/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Ingredient $ingredient */
        $ingredient = $this->ingredientRepository->findWithoutFail($id);

        if (empty($ingredient)) {
            return $this->sendError('Ingredient not found');
        }

        $ingredient->delete();

        return $this->sendResponse($id, 'Ingredient deleted successfully');
    }
}
