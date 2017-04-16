<?php

use Faker\Factory as Faker;
use App\Models\subcategory;
use App\Repositories\subcategoryRepository;

trait MakesubcategoryTrait
{
    /**
     * Create fake instance of subcategory and save it in database
     *
     * @param array $subcategoryFields
     * @return subcategory
     */
    public function makesubcategory($subcategoryFields = [])
    {
        /** @var subcategoryRepository $subcategoryRepo */
        $subcategoryRepo = App::make(subcategoryRepository::class);
        $theme = $this->fakesubcategoryData($subcategoryFields);
        return $subcategoryRepo->create($theme);
    }

    /**
     * Get fake instance of subcategory
     *
     * @param array $subcategoryFields
     * @return subcategory
     */
    public function fakesubcategory($subcategoryFields = [])
    {
        return new subcategory($this->fakesubcategoryData($subcategoryFields));
    }

    /**
     * Get fake data of subcategory
     *
     * @param array $postFields
     * @return array
     */
    public function fakesubcategoryData($subcategoryFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'image' => $fake->word,
            'category_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $subcategoryFields);
    }
}
