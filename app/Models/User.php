<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'is_admin'          => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = ['is_admin' => false];


    /**
     * Get the comments for the User.
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');

    }//end comments()


    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return ucwords($this->first_name.' '.$this->last_name);

    }//end getFullNameAttribute()


    /**
     * Scope a query to only include admin users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmin($query)
    {
        return $query->where('is_admin', true);

    }//end scopeAdmin()


    /**
     * Scope a query to only include visitor users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisitor($query)
    {
        return $query->where('is_admin', false);

    }//end scopeVisitor()


}//end class
