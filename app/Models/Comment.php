<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'user_id', 'comment'
    ];

    /**
     * Get the article that the comment wrote on.
     */
    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

    /**
     * Get the user that the created the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
