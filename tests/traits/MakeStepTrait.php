<?php

use Faker\Factory as Faker;
use App\Models\Step;
use App\Repositories\StepRepository;

trait MakeStepTrait
{
    /**
     * Create fake instance of Step and save it in database
     *
     * @param array $stepFields
     * @return Step
     */
    public function makeStep($stepFields = [])
    {
        /** @var StepRepository $stepRepo */
        $stepRepo = App::make(StepRepository::class);
        $theme = $this->fakeStepData($stepFields);
        return $stepRepo->create($theme);
    }

    /**
     * Get fake instance of Step
     *
     * @param array $stepFields
     * @return Step
     */
    public function fakeStep($stepFields = [])
    {
        return new Step($this->fakeStepData($stepFields));
    }

    /**
     * Get fake data of Step
     *
     * @param array $postFields
     * @return array
     */
    public function fakeStepData($stepFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'image' => $fake->word,
            'recipe_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $stepFields);
    }
}
