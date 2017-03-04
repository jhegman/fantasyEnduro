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
    public function index()
    {
    	$athletes = Racer::all();
   		return view('athlete.athletes',compact('athletes'));
    }

	//Make Athletes Clickable
	public function showAthletes($id)
	{
		$banner_photos = array('../img/richie.jpg','../img/richie1.jpg','../img/cecile2.jpg');
		$photo = $banner_photos[rand(0,2)];

		$athlete = Racer::findOrFail($id);
		//Stats
		$racesWon = $athlete->racesWon();
		$stageWins = $athlete->stageWins();
		$points = $athlete->pointsScored();
		$athleteData = Racer::find($id)->races()->where('overall_place', 1)->get();

		//Results
		$result = Racer::find($id)->races()->get();
		
		return view('athlete.showAthletes',compact('athlete','racesWon','stageWins','athleteData','result','points','photo'));
	}
}
