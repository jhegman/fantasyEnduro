<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Racer extends Model
{
    public function getRacersRace()
    {
        return $this->belongsToMany('App\Race')->withTimestamps()->withPivot(
        	'overall_place',
        	'stage_1_time',
        	'stage_1_place',
        	'stage_2_time',
        	'stage_2_place',
        	'stage_3_time',
        	'stage_3_place',
        	'stage_4_time',
        	'stage_4_place',
        	'stage_5_time',
        	'stage_5_place',
        	'stage_6_time',
        	'stage_6_place',
            'points'
    	);
    }

    public function lineups() {
        return $this->hasMany('App\Lineup');
    }
}
