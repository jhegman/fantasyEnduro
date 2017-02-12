<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Race;
use App\Racer;
use Auth;

class AthleteController extends Controller
{
    
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'isVerified']);
    }
    
    //Display Table of Athlete
    public function index(){
    	$athletes = Racer::all();
   		return view('athlete.athletes',compact('athletes'));
    }

	//Make Athletes Clickable
	public function showAthletes($id){
		$athlete = Racer::findOrFail($id);
		$athleteData = Racer::find($id)->races()->where('overall_place', 1)->get();
		$racesWon = count($athleteData);
		$result = Racer::find($id)->races()->get();
		$points = 0;
		foreach ($result as $key => $race) {
			$points += $race->pivot->points;
		}
		
		$stageWins = 0;
		for ($i=1; $i < 8 ; $i++) { 
			$stageData = Racer::find($id)
			->races()
			->where('stage_' . $i . '_place', 1)
			->get();
			$stageWins += count($stageData);

		}
		
		return view('athlete.showAthletes',compact('athlete','racesWon','stageWins','athleteData','result','points'));
	}
}
