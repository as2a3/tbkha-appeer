<?php

use Faker\Factory as Faker;
use App\Models\image;
use App\Repositories\imageRepository;

trait MakeimageTrait
{
    /**
     * Create fake instance of image and save it in database
     *
     * @param array $imageFields
     * @return image
     */
    public function makeimage($imageFields = [])
    {
        /** @var imageRepository $imageRepo */
        $imageRepo = App::make(imageRepository::class);
        $theme = $this->fakeimageData($imageFields);
        return $imageRepo->create($theme);
    }

    /**
     * Get fake instance of image
     *
     * @param array $imageFields
     * @return image
     */
    public function fakeimage($imageFields = [])
    {
        return new image($this->fakeimageData($imageFields));
    }

    /**
     * Get fake data of image
     *
     * @param array $postFields
     * @return array
     */
    public function fakeimageData($imageFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $imageFields);
    }
}
