<?php

use Faker\Factory as Faker;
use App\Models\Recipe;
use App\Repositories\RecipeRepository;

trait MakeRecipeTrait
{
    /**
     * Create fake instance of Recipe and save it in database
     *
     * @param array $recipeFields
     * @return Recipe
     */
    public function makeRecipe($recipeFields = [])
    {
        /** @var RecipeRepository $recipeRepo */
        $recipeRepo = App::make(RecipeRepository::class);
        $theme = $this->fakeRecipeData($recipeFields);
        return $recipeRepo->create($theme);
    }

    /**
     * Get fake instance of Recipe
     *
     * @param array $recipeFields
     * @return Recipe
     */
    public function fakeRecipe($recipeFields = [])
    {
        return new Recipe($this->fakeRecipeData($recipeFields));
    }

    /**
     * Get fake data of Recipe
     *
     * @param array $postFields
     * @return array
     */
    public function fakeRecipeData($recipeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'image' => $fake->word,
            'user_id' => $fake->randomDigitNotNull,
            'category_id' => $fake->randomDigitNotNull,
            'number_of_persons' => $fake->randomDigitNotNull,
            'preparation_time' => $fake->word,
            'description' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $recipeFields);
    }
}
