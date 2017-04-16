<?php

use App\Models\image;
use App\Repositories\imageRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class imageRepositoryTest extends TestCase
{
    use MakeimageTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var imageRepository
     */
    protected $imageRepo;

    public function setUp()
    {
        parent::setUp();
        $this->imageRepo = App::make(imageRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateimage()
    {
        $image = $this->fakeimageData();
        $createdimage = $this->imageRepo->create($image);
        $createdimage = $createdimage->toArray();
        $this->assertArrayHasKey('id', $createdimage);
        $this->assertNotNull($createdimage['id'], 'Created image must have id specified');
        $this->assertNotNull(image::find($createdimage['id']), 'image with given id must be in DB');
        $this->assertModelData($image, $createdimage);
    }

    /**
     * @test read
     */
    public function testReadimage()
    {
        $image = $this->makeimage();
        $dbimage = $this->imageRepo->find($image->id);
        $dbimage = $dbimage->toArray();
        $this->assertModelData($image->toArray(), $dbimage);
    }

    /**
     * @test update
     */
    public function testUpdateimage()
    {
        $image = $this->makeimage();
        $fakeimage = $this->fakeimageData();
        $updatedimage = $this->imageRepo->update($fakeimage, $image->id);
        $this->assertModelData($fakeimage, $updatedimage->toArray());
        $dbimage = $this->imageRepo->find($image->id);
        $this->assertModelData($fakeimage, $dbimage->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteimage()
    {
        $image = $this->makeimage();
        $resp = $this->imageRepo->delete($image->id);
        $this->assertTrue($resp);
        $this->assertNull(image::find($image->id), 'image should not exist in DB');
    }
}
