<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipeApiTest extends TestCase
{
    use MakeRecipeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateRecipe()
    {
        $recipe = $this->fakeRecipeData();
        $this->json('POST', '/api/v1/recipes', $recipe);

        $this->assertApiResponse($recipe);
    }

    /**
     * @test
     */
    public function testReadRecipe()
    {
        $recipe = $this->makeRecipe();
        $this->json('GET', '/api/v1/recipes/'.$recipe->id);

        $this->assertApiResponse($recipe->toArray());
    }

    /**
     * @test
     */
    public function testUpdateRecipe()
    {
        $recipe = $this->makeRecipe();
        $editedRecipe = $this->fakeRecipeData();

        $this->json('PUT', '/api/v1/recipes/'.$recipe->id, $editedRecipe);

        $this->assertApiResponse($editedRecipe);
    }

    /**
     * @test
     */
    public function testDeleteRecipe()
    {
        $recipe = $this->makeRecipe();
        $this->json('DELETE', '/api/v1/recipes/'.$recipe->iidd);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/recipes/'.$recipe->id);

        $this->assertResponseStatus(404);
    }
}
