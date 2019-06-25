<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];


    /**
     * Get the articles for the Category.
     */
    public function articles()
    {
        return $this->hasMany('App\Models\Article');

    }//end articles()


}//end class
