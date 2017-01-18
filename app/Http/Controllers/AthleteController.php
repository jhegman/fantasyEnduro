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
		return view('show',compact('athlete', 'stageWins'));
	}
}
