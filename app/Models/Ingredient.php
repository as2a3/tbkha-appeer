<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Ingredient
 * @package App\Models
 * @version November 7, 2016, 9:05 am UTC
 */
class Ingredient extends Model
{
    use SoftDeletes;

    public $table = 'ingredients';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'recipe_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'recipe_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'recipe_id' => 'recipe_id integer:unsigned:foreign,recipes,id number'
    ];

    public function recipe()
    {
        return $this->belongsTo('App\Models\Recipe');
    }
    

}
