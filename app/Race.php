<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    public function getRaceRacers()
    {
        return $this->belongsToMany('App\Racer')->withTimestamps();
    }
}
