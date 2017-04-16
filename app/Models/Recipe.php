<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Recipe
 * @package App\Models
 * @version November 7, 2016, 9:01 am UTC
 */
class Recipe extends Model
{
    use SoftDeletes;

    public $table = 'recipes';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image_id',
        'user_id',
        'category_id',
        'number_of_persons',
        'preparation_time',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image_id' => 'integer',
        'user_id' => 'integer',
        'category_id' => 'integer',
        'number_of_persons' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        // 'image' => 'required',
        'number_of_persons' => 'required',
        'preparation_time' => 'required'
    ];

  public function likes()
  {
      return $this->hasMany('App\Models\like');
  }

  public function ingredients()
  {
      return $this->hasMany('App\Models\Ingredient','recipe_id')->select(array('id','name'));
  }

  public function recipeSteps()
  {
      return $this->hasMany('App\Models\Step','recipe_id')->select(array('id','name','image_id'));
  }

  public function recipeCategory()
  {
      return $this->belongsTo('App\Models\Category','category_id')->select(array('id','name','image_id','parent_category'));
  }

  public function user()
  {
      return $this->belongsTo('App\Models\User','user_id')->select(array('id','name','avatar','email','user_token','facebook_token'));
  }

  public function image()
  {
      return $this->belongsTo('App\Models\image','image_id')->select(array('id','image'));
  }




}
