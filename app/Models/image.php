<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class image
 * @package App\Models
 * @version November 21, 2016, 9:32 am UTC
 */
class image extends Model
{
    use SoftDeletes;

    public $table = 'images';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'name' => 'required'
    ];

   public function category()
   {
       return $this->hasOne('App\Models\Category');
   }

   public function recipe()
   {
       return $this->hasOne('App\Models\Recipe');
   }

}
