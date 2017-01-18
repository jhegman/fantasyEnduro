<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Race;
use App\Racer;

class AthleteController extends Controller
{
    //Display Table of Athlete
    public function index(){
    	$athletes = Racer::all();
   		return view('athletes',compact('athletes'));
    }

	//Make Athletes Clickable
	public function show($id){
		$athlete = Racer::findOrFail($id);
		
		$athleteData = Racer::find($id)->getRacersRace()->where('overall_place', 1)->get();
		$racesWon = count($athleteData);

		$count = 0;
 		for($i=0;$i<7;$i++){
 		$stageData = Racer::find($id)->getRacersRace()->where('stage_'. ($i+1) .'_place', 1)->get();
 		if(count($stageData) > 0){
 			$count++;
 		}
 		}
 		$stageWins = $count;
		}
		
		return view('show',compact('athlete','racesWon','stageWins'));
	}
}
