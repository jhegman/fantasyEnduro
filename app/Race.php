<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    public function racers()
    {
        return $this->belongsToMany('App\Racer')->withTimestamps()->withPivot(
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
            'points',
            'week'
    	);
    }
}
