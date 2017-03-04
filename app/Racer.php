<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Racer extends Model
{
    /**
     * Get athletes races
     * @return App\Race
     */
    public function races()
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
            'points',
            'week'
    	);
    }

    /**
     * Get all lineups athlete is in
     * @return App\Lineup
     */
    public function lineups()
    {
        return $this->hasMany('App\Lineup');
    }

    /**
     * Get number of races racer has won
     * @return int number of races won
     */
    public function racesWon()
    {
        $athleteRaces = $this->races()->where('overall_place', 1)->get();
        return count($athleteRaces);
    }

    /**
     * Get number of stage wins racer has
     * @return int Number of stage wins
     */
    public function stageWins()
    {
        $stageWins = 0;
        for ($i=1; $i < 8 ; $i++) { 
            $stageData = $this
            ->races()
            ->where('stage_' . $i . '_place', 1)
            ->get();
            $stageWins += count($stageData);
        }
        return $stageWins;
    }

    /**
     * Get number of points scored to date
     * @return int Points scored to date
     */
    public function pointsScored()
    {
        $results = $this->races()->get();
        $pointsScored = 0;
        foreach ($results as $key => $result) {
            $pointsScored += $result->pivot->points;
        }
        return $pointsScored;
    }

    /**
     * Retreive the top ranked men
     * @param  int $takeCount [description]
     * @return array top ranked men
     */
    public function scopeTopMen($query, $takeCount)
    {
        return $query->where('gender', 'Men')
        ->orderBy('points', 'DESC')
        ->take($takeCount)
        ->get();
    }

    /**
     * Retreive the top ranked women
     * @param  int $takeCount How many athletes to return
     * @return array top ranked women
     */
    public function scopeTopWomen($query, $takeCount)
    {
        return $query->where('gender', 'Women')
        ->orderBy('points', 'DESC')
        ->take($takeCount)
        ->get();
    }
}
