<?php

use App\Models\Recipe;
use App\Repositories\RecipeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipeRepositoryTest extends TestCase
{
    use MakeRecipeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var RecipeRepository
     */
    protected $recipeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->recipeRepo = App::make(RecipeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateRecipe()
    {
        $recipe = $this->fakeRecipeData();
        $createdRecipe = $this->recipeRepo->create($recipe);
        $createdRecipe = $createdRecipe->toArray();
        $this->assertArrayHasKey('id', $createdRecipe);
        $this->assertNotNull($createdRecipe['id'], 'Created Recipe must have id specified');
        $this->assertNotNull(Recipe::find($createdRecipe['id']), 'Recipe with given id must be in DB');
        $this->assertModelData($recipe, $createdRecipe);
    }

    /**
     * @test read
     */
    public function testReadRecipe()
    {
        $recipe = $this->makeRecipe();
        $dbRecipe = $this->recipeRepo->find($recipe->id);
        $dbRecipe = $dbRecipe->toArray();
        $this->assertModelData($recipe->toArray(), $dbRecipe);
    }

    /**
     * @test update
     */
    public function testUpdateRecipe()
    {
        $recipe = $this->makeRecipe();
        $fakeRecipe = $this->fakeRecipeData();
        $updatedRecipe = $this->recipeRepo->update($fakeRecipe, $recipe->id);
        $this->assertModelData($fakeRecipe, $updatedRecipe->toArray());
        $dbRecipe = $this->recipeRepo->find($recipe->id);
        $this->assertModelData($fakeRecipe, $dbRecipe->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteRecipe()
    {
        $recipe = $this->makeRecipe();
        $resp = $this->recipeRepo->delete($recipe->id);
        $this->assertTrue($resp);
        $this->assertNull(Recipe::find($recipe->id), 'Recipe should not exist in DB');
    }
}
