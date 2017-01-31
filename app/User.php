<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getLineup()
    {
        return $this->hasMany('App\Lineup');
    }

    /**
    * Get the leagues associated with each user
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function leagues()
    {
        return $this->belongsToMany('App\League')->withTimestamps();
    }

    /**
    * Get the points associated with each user
    *
    * @return \Illuminate\Database\Eloquent\Relations\hasMany
    */
    public function points()
    {
        return $this->hasMany('App\Point')->withTimestamps();
    }


}
