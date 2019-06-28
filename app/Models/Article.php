<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'body',
        'is_published',
        'category_id',
    ];

    /**
     * Get the category that the article assigned to.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }//end category()


    /**
     * Get the comments of the article.
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }//end comments()


    /**
     * Scope a query to only include published articles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }//end scopePublished()


    /**
     * Scope a query to only include pending articles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('is_published', false);
    }//end scopePending()
}//end class
