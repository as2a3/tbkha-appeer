<?php

use Faker\Factory as Faker;
use App\Models\Ingredient;
use App\Repositories\IngredientRepository;

trait MakeIngredientTrait
{
    /**
     * Create fake instance of Ingredient and save it in database
     *
     * @param array $ingredientFields
     * @return Ingredient
     */
    public function makeIngredient($ingredientFields = [])
    {
        /** @var IngredientRepository $ingredientRepo */
        $ingredientRepo = App::make(IngredientRepository::class);
        $theme = $this->fakeIngredientData($ingredientFields);
        return $ingredientRepo->create($theme);
    }

    /**
     * Get fake instance of Ingredient
     *
     * @param array $ingredientFields
     * @return Ingredient
     */
    public function fakeIngredient($ingredientFields = [])
    {
        return new Ingredient($this->fakeIngredientData($ingredientFields));
    }

    /**
     * Get fake data of Ingredient
     *
     * @param array $postFields
     * @return array
     */
    public function fakeIngredientData($ingredientFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'recipe_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $ingredientFields);
    }
}
