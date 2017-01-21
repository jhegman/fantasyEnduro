<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
	/**
    * Get the users associated with each league
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function users()
    {
    	return $this->belongsToMany('App\User');
    }
}
