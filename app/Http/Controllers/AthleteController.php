<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Race;
use App\Racer;
use DB;

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

		$stageWins = 0;
		for ($i=1; $i < 8 ; $i++) { 
			$stageData = Racer::find($id)
			->getRacersRace()
			->where('stage_' . $i . '_place', 1)
			->get();
			$stageWins += count($stageData);
		}
		
		return view('show',compact('athlete','racesWon','stageWins'));
	}
}
