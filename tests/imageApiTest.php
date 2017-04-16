<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class imageApiTest extends TestCase
{
    use MakeimageTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateimage()
    {
        $image = $this->fakeimageData();
        $this->json('POST', '/api/v1/images', $image);

        $this->assertApiResponse($image);
    }

    /**
     * @test
     */
    public function testReadimage()
    {
        $image = $this->makeimage();
        $this->json('GET', '/api/v1/images/'.$image->id);

        $this->assertApiResponse($image->toArray());
    }

    /**
     * @test
     */
    public function testUpdateimage()
    {
        $image = $this->makeimage();
        $editedimage = $this->fakeimageData();

        $this->json('PUT', '/api/v1/images/'.$image->id, $editedimage);

        $this->assertApiResponse($editedimage);
    }

    /**
     * @test
     */
    public function testDeleteimage()
    {
        $image = $this->makeimage();
        $this->json('DELETE', '/api/v1/images/'.$image->iidd);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/images/'.$image->id);

        $this->assertResponseStatus(404);
    }
}
