<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class subcategory
 * @package App\Models
 * @version November 10, 2016, 11:48 am UTC
 */
class subcategory extends Model
{
    use SoftDeletes;

    public $table = 'subcategories';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'category_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'image' => 'required',
        'category_id' => 'required'
    ];

    
}
