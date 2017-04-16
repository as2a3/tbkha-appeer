<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class likeApiTest extends TestCase
{
    use MakelikeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatelike()
    {
        $like = $this->fakelikeData();
        $this->json('POST', '/api/v1/likes', $like);

        $this->assertApiResponse($like);
    }

    /**
     * @test
     */
    public function testReadlike()
    {
        $like = $this->makelike();
        $this->json('GET', '/api/v1/likes/'.$like->id);

        $this->assertApiResponse($like->toArray());
    }

    /**
     * @test
     */
    public function testUpdatelike()
    {
        $like = $this->makelike();
        $editedlike = $this->fakelikeData();

        $this->json('PUT', '/api/v1/likes/'.$like->id, $editedlike);

        $this->assertApiResponse($editedlike);
    }

    /**
     * @test
     */
    public function testDeletelike()
    {
        $like = $this->makelike();
        $this->json('DELETE', '/api/v1/likes/'.$like->iidd);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/likes/'.$like->id);

        $this->assertResponseStatus(404);
    }
}
