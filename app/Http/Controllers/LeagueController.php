<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Race;
use App\Racer;
use App\League;
use Auth;

class LeagueController extends Controller
{
    
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Display Table of Athlete
    public function displayLeagues(){
    	$leagues = League::all();
   		return view('league.leagues',compact('leagues'));
    }

    public function showLeague($id){
    	$league = League::findOrFail($id);
    	$users = $league->users;

    	return view('league.showLeague',compact('league','users'));
    }
}