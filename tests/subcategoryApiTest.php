<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class subcategoryApiTest extends TestCase
{
    use MakesubcategoryTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatesubcategory()
    {
        $subcategory = $this->fakesubcategoryData();
        $this->json('POST', '/api/v1/subcategories', $subcategory);

        $this->assertApiResponse($subcategory);
    }

    /**
     * @test
     */
    public function testReadsubcategory()
    {
        $subcategory = $this->makesubcategory();
        $this->json('GET', '/api/v1/subcategories/'.$subcategory->id);

        $this->assertApiResponse($subcategory->toArray());
    }

    /**
     * @test
     */
    public function testUpdatesubcategory()
    {
        $subcategory = $this->makesubcategory();
        $editedsubcategory = $this->fakesubcategoryData();

        $this->json('PUT', '/api/v1/subcategories/'.$subcategory->id, $editedsubcategory);

        $this->assertApiResponse($editedsubcategory);
    }

    /**
     * @test
     */
    public function testDeletesubcategory()
    {
        $subcategory = $this->makesubcategory();
        $this->json('DELETE', '/api/v1/subcategories/'.$subcategory->iidd);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/subcategories/'.$subcategory->id);

        $this->assertResponseStatus(404);
    }
}
