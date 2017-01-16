<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Racer extends Model
{
    public function getRacersRace()
    {
        return $this->belongsToMany('App\Race');
    }
}
