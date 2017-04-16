<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 * @package App\Models
 * @version November 7, 2016, 8:52 am UTC
 */
class Category extends Model
{
    use SoftDeletes;

    public $table = 'categories';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image_id',
        'parent'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    public function recipes()
    {
        return $this->hasMany('App\Models\Recipe');
    }

    public function parentCategory()
    {
        return $this->belongsTo(self::class, 'parent_category','id')->select(array('id','name','image_id'));
    }

    public function subcategories()
    {
        return $this->hasMany(self::class, 'parent_category','id')->select(array('id','name','image_id'));
    }

    public function image()
    {
        return $this->belongsTo('App\Models\image')->select(array('id','image'));
    }

}
