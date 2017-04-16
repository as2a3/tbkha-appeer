<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IngredientApiTest extends TestCase
{
    use MakeIngredientTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateIngredient()
    {
        $ingredient = $this->fakeIngredientData();
        $this->json('POST', '/api/v1/ingredients', $ingredient);

        $this->assertApiResponse($ingredient);
    }

    /**
     * @test
     */
    public function testReadIngredient()
    {
        $ingredient = $this->makeIngredient();
        $this->json('GET', '/api/v1/ingredients/'.$ingredient->id);

        $this->assertApiResponse($ingredient->toArray());
    }

    /**
     * @test
     */
    public function testUpdateIngredient()
    {
        $ingredient = $this->makeIngredient();
        $editedIngredient = $this->fakeIngredientData();

        $this->json('PUT', '/api/v1/ingredients/'.$ingredient->id, $editedIngredient);

        $this->assertApiResponse($editedIngredient);
    }

    /**
     * @test
     */
    public function testDeleteIngredient()
    {
        $ingredient = $this->makeIngredient();
        $this->json('DELETE', '/api/v1/ingredients/'.$ingredient->iidd);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/ingredients/'.$ingredient->id);

        $this->assertResponseStatus(404);
    }
}
