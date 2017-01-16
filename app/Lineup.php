<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lineup extends Model
{
    public function getLineupUser()
    {
        return $this->hasMany('App\User');
    }
}
