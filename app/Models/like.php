<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class like
 * @package App\Models
 * @version November 17, 2016, 1:42 pm UTC
 */
class like extends Model
{
    use SoftDeletes;

    public $table = 'likes';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'recipe_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'recipe_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'recipe_id' => 'required'
    ];

    public function recipe()
    {
        return $this->belongsTo('App\Models\Recipe');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

}
