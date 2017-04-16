<?php

namespace App\Repositories;

use App\Models\Ingredient;
use InfyOm\Generator\Common\BaseRepository;

class IngredientRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'recipe_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Ingredient::class;
    }
}
