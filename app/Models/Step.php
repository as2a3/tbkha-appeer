<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Step
 * @package App\Models
 * @version November 7, 2016, 9:07 am UTC
 */
class Step extends Model
{
    use SoftDeletes;

    public $table = 'steps';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image_id',
        'recipe_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image_id' => 'integer',
        'recipe_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'recipe_id' => 'required'
    ];

    public function recipe()
    {
        return $this->belongsTo('App\Models\Recipe');
    }

    public function image()
    {
        return $this->belongsTo('App\Models\image')->select(array('id','image'));
    }


}
