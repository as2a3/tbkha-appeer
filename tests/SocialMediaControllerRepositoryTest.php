<?php

use App\Models\SocialMediaController;
use App\Repositories\SocialMediaControllerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SocialMediaControllerRepositoryTest extends TestCase
{
    use MakeSocialMediaControllerTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SocialMediaControllerRepository
     */
    protected $socialMediaControllerRepo;

    public function setUp()
    {
        parent::setUp();
        $this->socialMediaControllerRepo = App::make(SocialMediaControllerRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSocialMediaController()
    {
        $socialMediaController = $this->fakeSocialMediaControllerData();
        $createdSocialMediaController = $this->socialMediaControllerRepo->create($socialMediaController);
        $createdSocialMediaController = $createdSocialMediaController->toArray();
        $this->assertArrayHasKey('id', $createdSocialMediaController);
        $this->assertNotNull($createdSocialMediaController['id'], 'Created SocialMediaController must have id specified');
        $this->assertNotNull(SocialMediaController::find($createdSocialMediaController['id']), 'SocialMediaController with given id must be in DB');
        $this->assertModelData($socialMediaController, $createdSocialMediaController);
    }

    /**
     * @test read
     */
    public function testReadSocialMediaController()
    {
        $socialMediaController = $this->makeSocialMediaController();
        $dbSocialMediaController = $this->socialMediaControllerRepo->find($socialMediaController->id);
        $dbSocialMediaController = $dbSocialMediaController->toArray();
        $this->assertModelData($socialMediaController->toArray(), $dbSocialMediaController);
    }

    /**
     * @test update
     */
    public function testUpdateSocialMediaController()
    {
        $socialMediaController = $this->makeSocialMediaController();
        $fakeSocialMediaController = $this->fakeSocialMediaControllerData();
        $updatedSocialMediaController = $this->socialMediaControllerRepo->update($fakeSocialMediaController, $socialMediaController->id);
        $this->assertModelData($fakeSocialMediaController, $updatedSocialMediaController->toArray());
        $dbSocialMediaController = $this->socialMediaControllerRepo->find($socialMediaController->id);
        $this->assertModelData($fakeSocialMediaController, $dbSocialMediaController->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSocialMediaController()
    {
        $socialMediaController = $this->makeSocialMediaController();
        $resp = $this->socialMediaControllerRepo->delete($socialMediaController->id);
        $this->assertTrue($resp);
        $this->assertNull(SocialMediaController::find($socialMediaController->id), 'SocialMediaController should not exist in DB');
    }
}
