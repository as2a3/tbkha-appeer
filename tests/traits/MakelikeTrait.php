<?php

use Faker\Factory as Faker;
use App\Models\like;
use App\Repositories\likeRepository;

trait MakelikeTrait
{
    /**
     * Create fake instance of like and save it in database
     *
     * @param array $likeFields
     * @return like
     */
    public function makelike($likeFields = [])
    {
        /** @var likeRepository $likeRepo */
        $likeRepo = App::make(likeRepository::class);
        $theme = $this->fakelikeData($likeFields);
        return $likeRepo->create($theme);
    }

    /**
     * Get fake instance of like
     *
     * @param array $likeFields
     * @return like
     */
    public function fakelike($likeFields = [])
    {
        return new like($this->fakelikeData($likeFields));
    }

    /**
     * Get fake data of like
     *
     * @param array $postFields
     * @return array
     */
    public function fakelikeData($likeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'recipe_id' => $fake->randomDigitNotNull,
            'user_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $likeFields);
    }
}
