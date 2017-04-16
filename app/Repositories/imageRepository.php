<?php

namespace App\Repositories;

use App\Models\image;
use InfyOm\Generator\Common\BaseRepository;

class imageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return image::class;
    }
}
