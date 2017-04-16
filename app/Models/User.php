<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App\Models
 * @version November 6, 2016, 9:45 am UTC
 */
class User extends Model
{
    use SoftDeletes;

    public $table = 'users';


    protected $dates = ['deleted_at'];


    public $fillable = [
      'name','email','facebook_id','avatar','facebook_token','user_token','password','admin' , 'FCM_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'avatar' => 'string',
        'facebook_id' => 'integer',
        'facebook_token' => 'integer',
        'user_token' => 'string',
        'FCM_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'FCM_token' => 'admin integer number'
    ];

    public function recipes()
    {
        return $this->hasMany('App\Models\Recipe','user_id');
    }

}
