<?php

namespace App\Repositories;

use App\Models\Step;
use InfyOm\Generator\Common\BaseRepository;

class StepRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'recipe_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Step::class;
    }
}
