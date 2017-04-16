<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SocialMediaControllerApiTest extends TestCase
{
    use MakeSocialMediaControllerTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSocialMediaController()
    {
        $socialMediaController = $this->fakeSocialMediaControllerData();
        $this->json('POST', '/api/v1/socialMediaControllers', $socialMediaController);

        $this->assertApiResponse($socialMediaController);
    }

    /**
     * @test
     */
    public function testReadSocialMediaController()
    {
        $socialMediaController = $this->makeSocialMediaController();
        $this->json('GET', '/api/v1/socialMediaControllers/'.$socialMediaController->id);

        $this->assertApiResponse($socialMediaController->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSocialMediaController()
    {
        $socialMediaController = $this->makeSocialMediaController();
        $editedSocialMediaController = $this->fakeSocialMediaControllerData();

        $this->json('PUT', '/api/v1/socialMediaControllers/'.$socialMediaController->id, $editedSocialMediaController);

        $this->assertApiResponse($editedSocialMediaController);
    }

    /**
     * @test
     */
    public function testDeleteSocialMediaController()
    {
        $socialMediaController = $this->makeSocialMediaController();
        $this->json('DELETE', '/api/v1/socialMediaControllers/'.$socialMediaController->iidd);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/socialMediaControllers/'.$socialMediaController->id);

        $this->assertResponseStatus(404);
    }
}
