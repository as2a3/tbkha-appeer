<?php

namespace App\Repositories;

use App\Models\subcategory;
use InfyOm\Generator\Common\BaseRepository;

class subcategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'category_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return subcategory::class;
    }
}
