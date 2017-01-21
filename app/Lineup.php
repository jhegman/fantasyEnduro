<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lineup extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function racer()
    {
    	return $this->belongsTo('App\Racer');
    }
}
