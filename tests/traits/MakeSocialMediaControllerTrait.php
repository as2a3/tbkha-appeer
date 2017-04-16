<?php

use Faker\Factory as Faker;
use App\Models\SocialMediaController;
use App\Repositories\SocialMediaControllerRepository;

trait MakeSocialMediaControllerTrait
{
    /**
     * Create fake instance of SocialMediaController and save it in database
     *
     * @param array $socialMediaControllerFields
     * @return SocialMediaController
     */
    public function makeSocialMediaController($socialMediaControllerFields = [])
    {
        /** @var SocialMediaControllerRepository $socialMediaControllerRepo */
        $socialMediaControllerRepo = App::make(SocialMediaControllerRepository::class);
        $theme = $this->fakeSocialMediaControllerData($socialMediaControllerFields);
        return $socialMediaControllerRepo->create($theme);
    }

    /**
     * Get fake instance of SocialMediaController
     *
     * @param array $socialMediaControllerFields
     * @return SocialMediaController
     */
    public function fakeSocialMediaController($socialMediaControllerFields = [])
    {
        return new SocialMediaController($this->fakeSocialMediaControllerData($socialMediaControllerFields));
    }

    /**
     * Get fake data of SocialMediaController
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSocialMediaControllerData($socialMediaControllerFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $socialMediaControllerFields);
    }
}
