<?php

use App\Models\Ingredient;
use App\Repositories\IngredientRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IngredientRepositoryTest extends TestCase
{
    use MakeIngredientTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var IngredientRepository
     */
    protected $ingredientRepo;

    public function setUp()
    {
        parent::setUp();
        $this->ingredientRepo = App::make(IngredientRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateIngredient()
    {
        $ingredient = $this->fakeIngredientData();
        $createdIngredient = $this->ingredientRepo->create($ingredient);
        $createdIngredient = $createdIngredient->toArray();
        $this->assertArrayHasKey('id', $createdIngredient);
        $this->assertNotNull($createdIngredient['id'], 'Created Ingredient must have id specified');
        $this->assertNotNull(Ingredient::find($createdIngredient['id']), 'Ingredient with given id must be in DB');
        $this->assertModelData($ingredient, $createdIngredient);
    }

    /**
     * @test read
     */
    public function testReadIngredient()
    {
        $ingredient = $this->makeIngredient();
        $dbIngredient = $this->ingredientRepo->find($ingredient->id);
        $dbIngredient = $dbIngredient->toArray();
        $this->assertModelData($ingredient->toArray(), $dbIngredient);
    }

    /**
     * @test update
     */
    public function testUpdateIngredient()
    {
        $ingredient = $this->makeIngredient();
        $fakeIngredient = $this->fakeIngredientData();
        $updatedIngredient = $this->ingredientRepo->update($fakeIngredient, $ingredient->id);
        $this->assertModelData($fakeIngredient, $updatedIngredient->toArray());
        $dbIngredient = $this->ingredientRepo->find($ingredient->id);
        $this->assertModelData($fakeIngredient, $dbIngredient->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteIngredient()
    {
        $ingredient = $this->makeIngredient();
        $resp = $this->ingredientRepo->delete($ingredient->id);
        $this->assertTrue($resp);
        $this->assertNull(Ingredient::find($ingredient->id), 'Ingredient should not exist in DB');
    }
}
