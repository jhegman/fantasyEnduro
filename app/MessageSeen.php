<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageSeen extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'league_id', 'last_viewed',
    ];
}
