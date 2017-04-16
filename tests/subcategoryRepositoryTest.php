<?php

use App\Models\subcategory;
use App\Repositories\subcategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class subcategoryRepositoryTest extends TestCase
{
    use MakesubcategoryTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var subcategoryRepository
     */
    protected $subcategoryRepo;

    public function setUp()
    {
        parent::setUp();
        $this->subcategoryRepo = App::make(subcategoryRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatesubcategory()
    {
        $subcategory = $this->fakesubcategoryData();
        $createdsubcategory = $this->subcategoryRepo->create($subcategory);
        $createdsubcategory = $createdsubcategory->toArray();
        $this->assertArrayHasKey('id', $createdsubcategory);
        $this->assertNotNull($createdsubcategory['id'], 'Created subcategory must have id specified');
        $this->assertNotNull(subcategory::find($createdsubcategory['id']), 'subcategory with given id must be in DB');
        $this->assertModelData($subcategory, $createdsubcategory);
    }

    /**
     * @test read
     */
    public function testReadsubcategory()
    {
        $subcategory = $this->makesubcategory();
        $dbsubcategory = $this->subcategoryRepo->find($subcategory->id);
        $dbsubcategory = $dbsubcategory->toArray();
        $this->assertModelData($subcategory->toArray(), $dbsubcategory);
    }

    /**
     * @test update
     */
    public function testUpdatesubcategory()
    {
        $subcategory = $this->makesubcategory();
        $fakesubcategory = $this->fakesubcategoryData();
        $updatedsubcategory = $this->subcategoryRepo->update($fakesubcategory, $subcategory->id);
        $this->assertModelData($fakesubcategory, $updatedsubcategory->toArray());
        $dbsubcategory = $this->subcategoryRepo->find($subcategory->id);
        $this->assertModelData($fakesubcategory, $dbsubcategory->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletesubcategory()
    {
        $subcategory = $this->makesubcategory();
        $resp = $this->subcategoryRepo->delete($subcategory->id);
        $this->assertTrue($resp);
        $this->assertNull(subcategory::find($subcategory->id), 'subcategory should not exist in DB');
    }
}
